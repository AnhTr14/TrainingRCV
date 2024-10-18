<?php

namespace App\Http\Controllers;

use App\Models\MstUser;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Validator;
use App\Exports\FailedUsersExport;
use App\Exports\TestExport;

class UserController extends Controller
{

    public function index()
    {
        $this->authorize('View User');
        $roles = Role::get();
        return view('user.index', compact(['roles']));
    }

    public function getListUsers(Request $request)
    {
        $this->authorize('View User');
        $params = $request->all();

        $query = MstUser::with('roles')->select('id', 'name', 'email', 'is_active')->where('is_delete', 0);

        if (!empty($params['filterName'])) {
            $query->where('name', 'LIKE', "%" . $params['filterName'] . "%");
        }

        if (!empty($params['filterEmail'])) {
            $query->where('email', 'LIKE', "%" . $params['filterEmail'] . "%");
        }

        if (!empty($params['filterRole'])) {
            $query->whereHas('roles', function ($q) use ($params) {
                $q->where('role_id', $params['filterRole']);
            });
        }

        if ($params['filterStatus'] != "") {
            $query->where('is_active', $params['filterStatus']);
        }

        return datatables()->of($query)

        ->addColumn('name', function($row) {
            return '<div class="edit-link" data-id="' . $row->id . '">' . $row->name . '</div>';
        })
            ->addColumn('role_name', function ($row) {
                if (!empty($row->roles[0])) {
                    return $row->roles[0]->name;
                }
                return "";
            })
            ->addColumn('action', function ($row) {
                $button = '';
                if (auth()->user()->can('Edit User')) {
                    $button .= '
                    <button class="edit btn btn-info btn-sm"  type="button" data-id="' . $row->id . '">
                        <i class="fas fa-pencil-alt"></i>
                    </button>';
                    if ($row->is_active == 1)
                        $button .= '
                            <button class="lock btn btn-primary btn-sm" type="button" data-id="' . $row->id . '" data-name="' . $row->name . '" data-status="' . $row->is_active . '">
                                <i class="fa fa-unlock"></i>
                            </button>';
                    else $button .= '
                            <button class="lock btn btn-primary btn-sm" type="button" data-id="' . $row->id . '" data-name="' . $row->name . '" data-status="' . $row->is_active . '">
                                <i class="fa fa-lock"></i>
                            </button>';
                }
                if (auth()->user()->can('Delete User')) {
                    $button .= '
                        <button class="delete btn btn-danger btn-sm" type="button" data-id="' . $row->id . '" data-name="' . $row->name . '">
                            <i class="fas fa-trash"></i>
                        </button>';
                }

                return $button;
            })
            ->rawColumns(['action', 'name'])
            ->make(true);
    }

    public function editUser($id)
    {
        $this->authorize('Edit User');
        return MstUser::with('roles')->find($id);
    }

    public function storeUser(UserRequest $request)
    {
        $this->authorize('Create User');
        $name = $request['name'];
        $email = $request['email'];
        $password = $request['password'];
        $role = $request['role'];

        $user = MstUser::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'is_active' => 1,
            'is_delete' => 0,
        ]);

        $user->save();

        $id = $user->id;

        $role = UserRole::create([
            'model_id' => $id,
            'role_id' => $role,
            'model_type' => get_class($user)
        ]);

        $user->save();

        return response()->json(['success' => "success", 'user' => $user]);
    }

    public function updateUser(Request $request)
    {
        $this->authorize('Edit User');
        $name = $request['name'];
        $password = $request['password'];
        $role = $request['role'];
        $id = $request['id'];
        $current_id = $request['current_id_edit'];

        $user = MstUser::find($id);
        $current_user = MstUser::find($id);
        if (!$current_user->hasRole(1)) {
            if ($user->hasRole(1)) return response()->json(['error' => "error"], 400);
        }

        $rules = [
            'name' => 'required',
        ];
        $message = [
            'name.required' => 'Vui lòng nhập họ tên',
        ];

        if ($password != "") {
            $rules['password'] = 'min:3';
            $message['password.min'] = 'Mật khẩu có ít nhất 3 ký tự';
        }

        $request->validate($rules, $message);

        if ($role) {
            UserRole::where('model_id', $id)
                ->update(['role_id' => $role]);
        }

        $user->name = $name;
        if ($password != "") {
            $user->password = Hash::make($password);
            $user->update();
            return response()->json(['id' => $id], 200);
        }

        $user->update();

        return response()->json(['id' => "0"], 200);
    }

    public function deleteUser(Request $request)
    {
        $this->authorize('Delete User');
        $id = $request->id;
        $user = MstUser::find($id);
        if ($user->hasRole(1)) return response()->json(['error' => "error"], 400);
        $user->is_delete = "1";
        $user->update();

        $userRole = UserRole::where('model_id', $id);
        $userRole->delete();

        return response()->json(['success' => "success"], 200);
    }

    public function lockUser(Request $request)
    {
        $this->authorize('Edit User');
        $id = $request->id;
        $user = MstUser::find($id);
        if ($user->hasRole(1)) return response()->json(['error' => "error"], 400);
        $user->is_active = abs(1 - $user->is_active);
        $user->update();

        return response()->json(['success' => "success"], 200);
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ], [
            'file.mimes' => 'Vui lòng chọn file có định dạng xlsx, xls, csv',
        ]);

        $failures = [];

        Excel::import(new UsersImport($failures), $file);
        $data = Excel::toCollection(new UsersImport($failures), $file)->first();
        Excel::store(new FailedUsersExport($data, $failures), 'failed-users.xlsx');
    }

    public function download() {
        $file_path = storage_path('\app\failed-users.xlsx');

        if (file_exists($file_path)) {
            return response()->download($file_path);
        } else {
            abort(404, 'File not found.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorize('View Role');
        return view('role.index');
    }

    public function getListRoles()
    {
        $this->authorize('View Role');
        $query = Role::select('id', 'name', 'guard_name')->get();
        return datatables()->of($query)
            ->addColumn('action', function ($row) {
                $button = "";
                if (auth()->user()->can('Edit Role')) {
                    $button .= '
                    <button class="info btn btn-info btn-sm" type="button" data-id="' . $row->id . '" data-name="' . $row->name . '">
                        <i class="fas fa-pencil-alt"></i>
                    </button>';
                }
                // if (auth()->user()->can('Delete Role')) {
                //     $button .= '
                //     <button class="delete btn btn-danger btn-sm" type="button" data-id="' . $row->id . '" data-name="' . $row->name . '">
                //         <i class="fas fa-trash"></i>
                //     </button>';
                // }
                
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getRole(Request $request)
    {
        $this->authorize('Edit Role');
        $id = $request->id;
        $role = Role::find($id);

        return $role;
    }

    public function updateRole(Request $request)
    {
        $this->authorize('Edit Role');
        $id = $request->id;
        $name = $request->name;
        $guard = "web";

        $role = Role::find($id);
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ], [
            'name.unique' => 'Vai trò đã tồn tại',
            'name.required' => 'Vui lòng nhập tên vai trò',
        ]);

        $role->name = $name;
        $role->guard_name = $guard;
        $role->update();


        return response()->json(['success' => 'Success']);
    }

    public function storeRole(Request $request)
    {
        $this->authorize('Create Role');
        $name = $request->name;

        $request->validate([
            'name' => 'required|unique:roles',
        ], [
            'name.unique' => 'Role đã tồn tại',
            'name.required' => 'Vui lòng nhập tên role',
        ]);

        Role::create([
            'name' => $name,
            'guard_name' => "web"
        ]);

        return response()->json(['success' => 'Success']);
    }

    public function deleteRole(Request $request)
    {
        $this->authorize('Delete Role');
        $id = $request->id;
        Role::where('id', $id)->delete();

        return response()->json(['success' => 'Success']);
    }

    public function changePermission (Request $request) {
        $this->authorize('Edit Role');
        $id = $request->roleId;
        $name = $request->roleName;
        $permissions = $request->checked;

        $role = Role::find($id);
        $request->validate([
            'roleName' => 'required|unique:roles,name,' . $role->id,
        ], [
            'roleName.unique' => 'Vai trò đã tồn tại',
            'roleName.required' => 'Vui lòng nhập tên vai trò',
        ]);

        $role->syncPermissions($permissions);
        $role->name = $name;
        $role->update();

        return response()->json(['success' => 'Success']);
    }
}

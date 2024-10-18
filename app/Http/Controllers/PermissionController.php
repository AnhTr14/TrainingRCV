<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function getListPermissions(Request $request)
    {
        $this->authorize('View Role');
        $roleId = $request->roleId;
        $role = Role::find($roleId);

        $query = Permission::select('id', 'name');
        if (!$role) {
            return datatables()->of($query)
            ->addColumn('checked', function () {
                $input = '<input type="checkbox" />';
                return $input;
            })
            ->rawColumns(['checked'])
            ->make(true);
        }
        
        $permissions = $role->permissions->pluck('id')->toArray();
        
        return datatables()->of($query)
            ->addColumn('checked', function ($row) use ($permissions) {
                $check = in_array($row->id, $permissions) ? "checked" : "";
                $input = '<input class="checkBox" type="checkbox" '. $check .' data-name="' . $row->name . '"/>';
                return $input;
            })
            ->rawColumns(['checked'])
            ->make(true);
    }
}

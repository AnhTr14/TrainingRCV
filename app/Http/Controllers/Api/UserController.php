<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MstUser;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUser() {
        $user = auth('sanctum')->user();
        return response()->json([
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'created_at' => $user->created_at,
            ],
        ]);
    }

    public function getUsers() {
        $users = MstUser::with('roles')
                        ->select('id', 'email', 'name', 'is_active') 
                        ->where('is_delete', 0)
                        ->get();

        $usersWithRoles = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'is_active' => $user->is_active,
                'role' => $user->roles->pluck('name')->first()
            ];
        });

        return response()->json($usersWithRoles);
    }
}

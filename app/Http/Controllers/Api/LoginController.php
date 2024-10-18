<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $tokenResult = $request->user()->createToken('auth', ['*'], now()->addWeek())->plainTextToken;
            
            return response()->json([
                'access_token' => $tokenResult,
                'user' => [
                    'id' => $request->user()->id,
                    'email' => $request->user()->email,
                    'name' => $request->user()->name,
                    'created_at' => $request->user()->created_at,
                ],
            ]);
        }
 
        return response()->json([
            'message' => 'Sai TKMK',
        ], 401);
    }

    public function logout() {
        request()->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}

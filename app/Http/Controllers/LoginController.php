<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\MstUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showForm(Request $request)
    {
        if (Auth::check()) return redirect()->route('productindex');
        return view('auth.login');
    }

    public function checkLogin(LoginRequest $request)
    {
        $email = $request['email'];
        $password = $request['password'];
        $message = "Mật khẩu không chính xác.";
        $user = MstUser::where('email', $email)->first();
        // $remember =  $request->has('remember') ? true : false;
        $remember =  $request['remember'];

        if (!$user || $user->is_delete == 1) $message = "Tài khoản không tồn tại.";
        else if ($user->is_active == 0) $message = "Tại khoản đã bị khóa.";
        else if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {

            $user->last_login_at = now();
            $user->last_login_ip = $request->ip();

            $user->save();
            return response()->json(['success' => true]);
        } 
        return response()->json(['loginError' => $message]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

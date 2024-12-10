<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('users.home');
        }
        return view('users.pages.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->loai_nguoidung !== 'user' || $user->trangthai !== 'active') {
                Auth::logout();
                return back()->withErrors([
                    'login' => 'Tài khoản không có quyền truy cập hoặc đã bị khóa.',
                ])->withInput($request->except('password'));
            }

            $request->session()->regenerate();
            return redirect()->intended(route('users.home'));
        }

        return back()->withErrors([
            'login' => 'Thông tin đăng nhập không chính xác.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('users.home');
    }
}

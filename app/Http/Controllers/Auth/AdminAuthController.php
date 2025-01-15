<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.pages.login.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->loai_nguoidung !== 'admin' || $user->trangthai !== 'active') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tài khoản không có quyền truy cập hoặc đã bị khóa',
                ]);
            }

            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login.form');
    }
}

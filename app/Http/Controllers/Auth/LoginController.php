<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{

    //không cần thiết
    // public function showLoginForm()
    // {
    //     if (Auth::check()) {
    //         return redirect()->route('users.home');
    //     }
    //     return view('users.pages.login');
    // }

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
                return response()->json([
                    'success' => false,
                    'message' => 'Tài khoản không có quyền truy cập hoặc đã bị khóa.',
                ], 403);
            }

            $request->session()->regenerate();
            return response()->json([
                'success' => true,
                'redirect_url' => $request->input('redirect_url', route('users.home')),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Thông tin đăng nhập không chính xác.',
        ], 401);
        // return back()->withErrors([
        //     'login' => 'Thông tin đăng nhập không chính xác.',
        // ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('users.home');
    }
}

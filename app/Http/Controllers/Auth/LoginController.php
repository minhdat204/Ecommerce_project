<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        // Kiểm tra tài khoản có tồn tại không
        $user = User::where('email', $request->email)->first();

        // Kiểm tra tài khoản có bị tạm khóa không
        if ($user && $user->thoi_gian_khoa && now()->lt($user->thoi_gian_khoa)) {
            $timeLeft = ceil(now()->diffInSeconds($user->thoi_gian_khoa));
            $minutes = ceil($timeLeft / 60);
            return response()->json([
            'success' => false,
            'message' => "Tài khoản này đã bị tạm khóa. Vui lòng thử lại sau {$minutes} phút"
            ], 423);
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Vui lòng nhập mật khẩu'
        ]);

        if (Auth::attempt($credentials)) {
            // Reset số lần đăng nhập nếu đăng nhập thành công
            if ($user) {
                $user->update([
                    'so_lan_khoa' => 0,
                    'thoi_gian_khoa' => null
                ]);
            }

            $user = Auth::user();

            if ($user->loai_nguoidung !== 'user' || $user->trangthai !== 'active') {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'Tài khoản không có quyền truy cập hoặc đã bị khóa',
                ], 403);
            }

            $request->session()->regenerate();
            return response()->json([
                'success' => true,
                'message' => 'Đăng nhập thành công',
                'redirect_url' => $request->input('redirect_url', route('users.home')),
            ]);
        }

        // đăng nhập thất bại
        if ($user) {
            // Tăng số lần đăng nhập thất bại
            $user->increment('so_lan_khoa');

            if ($user->so_lan_khoa >= 5) {
                // Tạm khóa tài khoản 3 phút
                $user->update([
                    'thoi_gian_khoa' => now()->addMinutes(3),
                    'so_lan_khoa' => 0 // Reset attempts
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Tài khoản bị tạm khóa 3 phút do đăng nhập sai quá nhiều lần'
                ], 423);
            }

            // Còn lại bao nhiêu lần thử
            $remainingAttempts = 5 - $user->so_lan_khoa;
            return response()->json([
                'success' => false,
                'message' => "Thông tin đăng nhập không chính xác. Còn {$remainingAttempts} lần thử"
            ], 401);
        }

        return response()->json([
            'success' => false,
            'message' => 'Thông tin đăng nhập không chính xác',
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
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Đăng xuất thành công',
                'redirect_url' => route('users.home')
            ]);
        }

        return redirect()->route('users.home');
    }
}

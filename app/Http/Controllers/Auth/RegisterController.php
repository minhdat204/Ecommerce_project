<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController
{
    public function showRegistrationForm()
    {
        return view('users.pages.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'hoten' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:nguoi_dung',
            'tendangnhap' => 'required|string|max:50|unique:nguoi_dung',
            'matkhau' => 'required|string|min:6|confirmed',
            'ngaysinh' => 'nullable|date',
            'gioitinh' => 'nullable|in:male,female',
        ], [
            'hoten.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'tendangnhap.required' => 'Vui lòng nhập tên đăng nhập',
            'tendangnhap.unique' => 'Tên đăng nhập đã tồn tại',
            'matkhau.required' => 'Vui lòng nhập mật khẩu',
            'matkhau.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'matkhau.confirmed' => 'Xác nhận mật khẩu không khớp',
        ]);

        $user = User::create([
            'hoten' => $request->hoten,
            'email' => $request->email,
            'tendangnhap' => $request->tendangnhap,
            'matkhau' => Hash::make($request->matkhau),
            'ngaysinh' => $request->ngaysinh,
            'gioitinh' => $request->gioitinh,
            'loai_nguoidung' => 'user',
            'trangthai' => 'active'
        ]);

        return redirect()->route('login')
            ->with('status', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }
}


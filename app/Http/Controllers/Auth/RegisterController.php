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
        $validator = validator($request->all(), [
            'register_name' => 'required|string|max:100',
            'register_email' => 'required|string|email|max:100|unique:nguoi_dung,email',
            'register_password' => 'required|string|min:6|confirmed',
            'register_phone' => 'nullable|string|max:20',
            'register_date' => 'nullable|date',
            'register_address' => 'nullable|string|max:255',
            'register_gender' => 'nullable|in:male,female',
        ], [
            'register_name.required' => 'Vui lòng nhập họ tên',
            'register_name.max' => 'Họ tên không được quá 100 ký tự',
            'register_email.required' => 'Vui lòng nhập email',
            'register_email.email' => 'Email không hợp lệ',
            'register_email.unique' => 'Email đã tồn tại',
            'register_password.required' => 'Vui lòng nhập mật khẩu',
            'register_password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'register_password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'register_phone.max' => 'Số điện thoại không hợp lệ',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::create([
                'hoten' => $request->register_name,
                'email' => $request->register_email,
                'matkhau' => Hash::make($request->register_password),
                'sodienthoai' => $request->register_phone,
                'ngaysinh' => $request->register_date,
                'diachi' => $request->register_address,
                'gioitinh' => $request->register_gender,
                'loai_nguoidung' => 'user',
                'trangthai' => 'active'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đăng ký thành công',
                'redirect_url' => route('users.home', ['openLogin' => true])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi đăng ký'
            ], 500);
        }
    }
}


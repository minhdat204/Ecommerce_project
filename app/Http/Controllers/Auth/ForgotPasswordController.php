<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\NguoiDung; // Thêm model NguoiDung
use App\Models\User;

class ForgotPasswordController
{
    public function showForgotForm()
    {
        return view('users.pages.passwords.reset-otp');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:nguoi_dung,email'
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.exists' => 'Email không tồn tại trong hệ thống'
        ]);

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        DB::table('password_reset_otps')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10),
                'created_at' => Carbon::now()
            ]
        );

        Mail::send('users.pages.passwords.otp-email', ['otp' => $otp], function($message) use($request) {
            $message->to($request->email);
            $message->subject('Mã xác nhận đặt lại mật khẩu');
        });

        return back()->with([
            'email_sent' => true,
            'status' => 'Mã xác nhận đã được gửi đến email của bạn!'
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $otp = implode('', $request->otp);

        $reset = DB::table('password_reset_otps')
            ->where('otp', $otp)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$reset) {
            return back()->withErrors(['otp' => 'Mã OTP không hợp lệ hoặc đã hết hạn']);
        }

        // Generate token for password reset
        $token = Str::random(64);

        // Store token in password_resets table
        DB::table('password_resets')->insert([
            'email' => $reset->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // Delete used OTP
        DB::table('password_reset_otps')->where('email', $reset->email)->delete();

        // Redirect to password reset form with token
        return redirect()->route('password.reset', ['token' => $token])
                        ->with('email', $reset->email);
    }

    public function showResetForm($token)
    {
        return view('users.pages.passwords.reset', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:nguoi_dung,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Kiểm tra token có hợp lệ không
        $passwordReset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Token không hợp lệ!']);
        }

        // Cập nhật mật khẩu
        $user = User::where('email', $request->email)->first();
        $user->matkhau = bcrypt($request->password);
        $user->save();

        // Xóa token đã sử dụng
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')
            ->with('status', 'Mật khẩu đã được đặt lại thành công!');
    }
}


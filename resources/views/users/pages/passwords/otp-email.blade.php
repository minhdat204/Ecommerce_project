
<!DOCTYPE html>
<html>
<head>
    <title>Mã xác nhận đặt lại mật khẩu</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #f9f9f9; padding: 20px; border-radius: 5px;">
        <h2 style="color: #333; text-align: center;">Đặt lại mật khẩu</h2>

        <p>Xin chào,</p>

        <p>Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu của bạn. Vui lòng sử dụng mã OTP sau để tiếp tục:</p>

        <div style="background: #eee; padding: 15px; text-align: center; margin: 20px 0;">
            <h1 style="letter-spacing: 5px; color: #333; margin: 0;">{{ $otp }}</h1>
        </div>

        <p>Mã này sẽ hết hạn sau 10 phút.</p>

        <p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>

        <p>Trân trọng,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>

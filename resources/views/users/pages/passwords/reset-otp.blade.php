
@extends('users.layouts.auth')
@push('styles')
    <link rel="stylesheet" href="{{asset('css/forgotPass.css')}}">
@endpush
@push('scripts')
    <script src="{{asset('js/forgotPass.js')}}"></script>
@endpush
@section('content')
    <div class="container">
        <!-- Step 1: Email Input -->
        <div id="emailStep" style="{{ !session('email_sent') ? '' : 'display: none' }}">
            <div class="header">
                <h1>Quên mật khẩu?</h1>
                <p>Nhập email của bạn để khôi phục mật khẩu</p>
            </div>

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required placeholder="Nhập email của bạn">
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">Gửi mã xác nhận</button>
            </form>

            <div class="links">
                <a href="{{ route('login') }}">Quay lại đăng nhập</a>
            </div>
        </div>

        <!-- Step 2: OTP Verification -->
        <div id="otpStep" style="{{ session('email_sent') ? '' : 'display: none' }}">
            <div class="header">
                <h1>Xác nhận OTP</h1>
                <p>Nhập mã OTP đã được gửi đến email của bạn</p>
            </div>

            <form action="{{ route('password.verify-otp') }}" method="POST">
                @csrf
                <div class="otp-inputs">
                    @for ($i = 1; $i <= 6; $i++)
                    <input type="text" name="otp[]" class="otp-input" maxlength="1" autocomplete="off" required>
                    @endfor
                </div>

                <button type="submit" class="submit-btn">Xác nhận</button>
            </form>

            <div class="links">
                <form action="{{ route('password.resend-otp') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-link">Gửi lại mã</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Add your JavaScript for OTP input handling here
        document.querySelectorAll('.otp-input').forEach((input, index) => {
            input.addEventListener('keyup', (e) => {
                if (e.key >= 0 && e.key <= 9) {
                    if (index < 5) {
                        document.querySelectorAll('.otp-input')[index + 1].focus();
                    }
                }
            });
        });
    </script>
@endsection

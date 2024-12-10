@extends('users.layouts.auth')
@push('styles')
    <link rel="stylesheet" href="{{asset('css/forgotPass.css')}}">
@endpush
@push('scripts')
    <script src="{{asset('js/forgotPass.js')}}"></script>
@endpush
@section('content')
    <div class="auth-form">
        <!-- Step 1: Email Input -->
        <div id="emailStep" style="{{ !session('email_sent') ? '' : 'display: none' }}">
            <h1>Reset Password</h1>
            <p class="auth-subtitle">Enter your email to reset your password</p>

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="Enter your email">
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">Send Reset Link</button>

                <div class="auth-footer">
                    <p>Remember your password? <a href="{{ route('login') }}">Back to Login</a></p>
                </div>
            </form>
        </div>

        <!-- Step 2: OTP Verification -->
        <div id="otpStep" style="{{ session('email_sent') ? '' : 'display: none' }}">
            <h1>OTP Verification</h1>
            <p class="auth-subtitle">Enter the OTP sent to your email</p>

            <form action="{{ route('password.verify-otp') }}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="otp-inputs">
                        @for ($i = 1; $i <= 6; $i++)
                        <input type="text" name="otp[]" class="otp-input form-input" maxlength="1" autocomplete="off" required>
                        @endfor
                    </div>
                    @error('otp')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">Verify OTP</button>

                <div class="auth-footer">
                    <form action="{{ route('password.resend-otp') }}" method="POST" class="resend-form">
                        @csrf
                        <p>Didn't receive the code?
                            <button type="submit" class="resend-btn">Resend OTP</button>
                        </p>
                    </form>
                </div>
            </form>
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

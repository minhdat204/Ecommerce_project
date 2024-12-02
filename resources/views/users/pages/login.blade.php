@extends('users.layouts.auth')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
@endpush
@push('scripts')
    <script src="{{asset('js/login.js')}}"></script>
@endpush

@section('content')
<div class="auth-form">
    <h1>Welcome Back</h1>
    <p class="auth-subtitle">Please sign in to continue</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label class="form-label">Email or Username</label>
            <input type="text" name="login" class="form-input @error('login') is-invalid @enderror"
                   placeholder="Enter your email or username" value="{{ old('login') }}">
            @error('login')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <div class="password-field">
                <input type="password" name="password" class="form-input @error('password') is-invalid @enderror"
                       placeholder="Enter your password">
                <button type="button" class="password-toggle">
                    <i class="fa fa-eye"></i>
                </button>
            </div>
            @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <div class="forgot-password-link">
                <a href="{{ route('password.request') }}">Forgot Password?</a>
            </div>
        </div>

        <button type="submit" class="login-button">Sign In</button>

        <div class="auth-footer">
            <p>Don't have an account? <a href="{{ route('register') }}">Create Account</a></p>
        </div>
    </form>
</div>
@endsection

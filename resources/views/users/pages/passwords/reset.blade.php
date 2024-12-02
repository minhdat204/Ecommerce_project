@extends('users.layouts.auth')
@push('styles')
    <link rel="stylesheet" href="{{asset('css/forgotPass.css')}}">
@endpush

@section('content')
<div class="auth-form">
    <h1>Reset Password</h1>
    <p class="auth-subtitle">Please enter your new password</p>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" id="newPasswordForm">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ session('email') }}">

        <div class="form-group">
            <label class="form-label">New Password</label>
            <input type="password" id="password" name="password"
                   class="form-input @error('password') is-invalid @enderror"
                   placeholder="Enter new password" required>
            @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Confirm Password</label>
            <input type="password" id="password_confirmation"
                   name="password_confirmation"
                   class="form-input"
                   placeholder="Confirm new password" required>
        </div>

        <button type="submit" class="submit-btn">Reset Password</button>

        <div class="auth-footer">
            <p>Remember your password? <a href="{{ route('login') }}">Back to Login</a></p>
        </div>
    </form>
</div>
@endsection

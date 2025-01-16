@extends('users.layouts.auth')

@section('title')
    Create Account
@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('css/register.css')}}">
@endpush
@push('scripts')
    <script src="{{asset('js/register.js')}}"></script>
@endpush

@section('content')
<div class="auth-form">
    <h1>Create Account</h1>
    <p class="auth-subtitle">Fill in the details to get started</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-grid">
            <div class="form-column"></div>
                <div class="form-group">
        <div class="form-group">
            <label class="form-label">Profile name <span class="required">*</span></label>
            <input type="text" name="hoten" class="form-input @error('hoten') is-invalid @enderror"
                   value="{{ old('hoten') }}" placeholder="Enter your Profile name" required>
            @error('hoten')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Email <span class="required">*</span></label>
            <input type="email" name="email" class="form-input @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" placeholder="Enter your Email address" required>
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Username <span class="required">*</span></label>
            <input type="text" name="tendangnhap" class="form-input @error('tendangnhap') is-invalid @enderror"
                   value="{{ old('tendangnhap') }}" placeholder="Enter your Username" required>
            @error('tendangnhap')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Password <span class="required">*</span></label>
            <div class="password-field">
                <input type="password" name="matkhau" class="form-input @error('matkhau') is-invalid @enderror"
                       placeholder="Enter your Password" required>
                <button type="button" class="password-toggle">Hide</button>
            </div>
            <div class="password-hint">Use 6 or more characters with a mix of letters, numbers or symbols</div>
            @error('matkhau')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Confirm Password <span class="required">*</span></label>
            <div class="password-field">
                <input type="password" name="matkhau_confirmation" class="form-input"
                       placeholder="Enter your Password" required>
                <button type="button" class="password-toggle">Hide</button>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">What's your date of birth?</label>
            <div class="date-input">
                <input type="date" name="ngaysinh" class="form-input @error('ngaysinh') is-invalid @enderror"
                       value="{{ old('ngaysinh') }}">
            </div>
            @error('ngaysinh')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">What's your gender? (optional)</label>
            <div class="gender-options">
                <label class="gender-option">
                    <input type="radio" name="gioitinh" value="female" {{ old('gioitinh') == 'female' ? 'checked' : '' }}>
                    <span>Female</span>
                </label>
                <label class="gender-option">
                    <input type="radio" name="gioitinh" value="male" {{ old('gioitinh') == 'male' ? 'checked' : '' }}>
                    <span>Male</span>
                </label>
            </div>
            @error('gioitinh')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="signup-button">Sign up</button>
        <div class="auth-footer">
            <p>Already have an account? <a href="{{ route('login') }}">Log in</a></p>
        </div>
    </form>
</div>
@endsection

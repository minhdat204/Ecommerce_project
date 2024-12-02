@extends('users.layouts.auth')
@push('styles')
    <link rel="stylesheet" href="{{asset('css/forgotPass.css')}}">
@endpush

@section('content')
<div class="container">
    <div id="newPasswordStep">
        <div class="header">
            <h1>Đặt mật khẩu mới</h1>
            <p>Vui lòng nhập mật khẩu mới của bạn</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}" id="newPasswordForm">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ session('email') }}">

            <div class="form-group">
                <label for="password">Mật khẩu mới</label>
                <input type="password" id="password" name="password" required
                    placeholder="Nhập mật khẩu mới">
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Xác nhận mật khẩu</label>
                <input type="password" id="password_confirmation"
                    name="password_confirmation" required
                    placeholder="Nhập lại mật khẩu mới">
            </div>

            <button type="submit" class="submit-btn">Đổi mật khẩu</button>
        </form>
    </div>

    @if(session('status'))
    <div class="success-message">
        {{ session('status') }}
    </div>
    @endif
</div>
@endsection

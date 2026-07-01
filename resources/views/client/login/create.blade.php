@extends('client.layout.master')

@section('content')


<section class="login-section">
    <div class="container">
        <div class="login-card">
            <div class="text-center">
                <h2>ورود به حساب</h2>
            </div>

            <form action="{{ route('client.login.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label">شماره موبایل</label>
                    <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                           placeholder=" 09123456789" value="{{ old('phone') }}">
                    @error('phone')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">رمز عبور</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                           placeholder="********">
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4 d-flex justify-content-between">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">مرا به خاطر بسپار</label>
                    </div>
                    <a href="#" style="color: #666; font-size: 14px;">رمز عبور را فراموش کرده‌اید؟</a>
                </div>

                <button type="submit" class="btn-auth btn-login">ورود به سایت</button>

                <div class="text-center mt-4">
                    <p>کاربر جدید هستید؟ <a href="{{ route('client.register') }}" style="color: #FFD93D; font-weight: bold;">ساخت حساب کاربری</a></p>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
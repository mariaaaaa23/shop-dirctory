@extends('client.layout.master') {{-- فرض بر این است که فایل اصلی قالب اینجاست --}}

@section('content')


<section class="register-section">
    <div class="container">
        <div class="register-card">
            <div class="text-center">
                <h2>عضویت </h2>
            </div>
            
            <form action="{{ route('client.register.store') }}" method="POST">
                @csrf


                <div class="mb-3">
                    <label class="form-label">شماره موبایل</label>
                    <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="09123456789">
                    @error('phone') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">رمز عبور</label>
                    <input type="password" name="password" class="form-control" placeholder="********">
                    @error('password') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                

                <button type="submit" class="btn-auth btn-register">تایید و ساخت حساب</button>
            </form>

            <div class="text-center mt-4">
                <p>قبلاً ثبت‌نام کرده‌اید؟ <a href="{{ route('client.login') }}" style="color: #FFD93D; font-weight: bold;">وارد شوید</a></p>
            </div>
        </div>
    </div>
</section>
@endsection
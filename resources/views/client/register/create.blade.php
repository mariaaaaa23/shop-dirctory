@extends('client.layout.master') 

@section('content')
<section class="register-section">
    <div class="container">
        <div class="register-card">
            <div class="text-center">
                <h2>عضویت</h2>
            </div>
            
            <form action="{{ route('client.register.store') }}" method="POST" id="registerForm">
                @csrf

                <div class="mb-3">
                    <label class="form-label">شماره موبایل</label>
                    <div class="input-group">
                        <input type="tel" id="phoneInput" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="09123456789">
                        <button type="button" id="sendSmsBtn" class="btn btn-outline-warning" style="border-radius: 0 5px 5px 0;">ارسال کد</button>
                    </div>
                    <small id="smsFeedback" class="text-red mt-1 d-block"></small>
                    @error('phone') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3" id="verificationCodeWrapper" style="display: none;">
                    <label class="form-label">کد تایید ۴ رقمی</label>
                    <input type="text" name="sms_code" id="smsCodeInput" class="form-control text-center" placeholder="----" maxlength="4">
                    @error('sms_code') <span class="error-text-dark">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">رمز عبور (برای ورودهای بعدی)</label>
                    <input type="password" name="password" class="form-control" placeholder="********">
                    @error('password') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                <button type="submit" id="submitBtn" class="btn-auth btn-register" disabled style="opacity: 0.6; cursor: not-allowed;">تایید و ساخت حساب</button>
            </form>

            <div class="text-center mt-4">
                <p>قبلاً ثبت‌نام کرده‌اید؟ <a href="{{ route('client.login') }}" style="color: #FFD93D; font-weight: bold;">وارد شوید</a></p>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('sendSmsBtn').addEventListener('click', function() {
    let phone = document.getElementById('phoneInput').value;
    let feedback = document.getElementById('smsFeedback');
    let codeWrapper = document.getElementById('verificationCodeWrapper');
    let submitBtn = document.getElementById('submitBtn');

    if(!phone || phone.length < 11) {
        alert('لطفاً شماره موبایل معتبر وارد کنید.');
        return;
    }

    feedback.innerText = 'در حال ارسال کد تایید...';
    
    // ارسال درخواست به بک‌اند برای تولید و ارسال پیامک
    fetch("{{ url('/register/send-sms') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ phone: phone })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            feedback.className = "text-success mt-1 d-block";
            feedback.innerText = data.message;
            codeWrapper.style.display = "block"; // نمایش فیلد کد تایید
            submitBtn.disabled = false;          // فعال شدن دکمه ثبت نام
            submitBtn.style.opacity = "1";
            submitBtn.style.cursor = "pointer";
        } else {
            feedback.className = "text-danger mt-1 d-block";
            feedback.innerText = data.message;
        }
    })
    .catch(error => {
        feedback.className = "text-danger mt-1 d-block";
        feedback.innerText = 'خطا در ارتباط با سرور. دوباره تلاش کنید.';
    });
});
</script>
@endsection
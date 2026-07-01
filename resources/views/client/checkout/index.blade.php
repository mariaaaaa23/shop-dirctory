@extends('client.layout.master')

@section('content')

@if(session('error'))
    <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-xl mb-4 font-medium text-xs text-center shadow-sm" dir="rtl">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-xl mb-4 font-medium text-xs text-center shadow-sm" dir="rtl">
        {{ session('success') }}
    </div>
@endif


<div class="container my-5 text-right" style="direction: rtl;">
    <div class="card shadow-sm p-4">
        <h3 class="fw-bold mb-4">اطلاعات تسویه حساب</h3>
        <p>مبلغ کل فاکتور شما: <span class="text-primary fw-bold">{{ number_format($totalAmount) }} تومان</span></p>
        
        <form action="{{ route('client.checkout.payment') }}" method="POST" class="mt-4 space-y-4">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-bold block text-xs mb-2">آدرس دقیق ارسال:</label>
                <textarea name="address" class="form-control w-full border rounded-xl p-2.5" rows="3" placeholder="استان، شهر، خیابان..." required>استان فارس شهرستان لارستان...</textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold block text-xs mb-2">شماره تماس:</label>
                <input type="text" name="phone" value="09908989891" class="form-control w-full border rounded-xl p-2.5" placeholder="0917..." required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold block text-xs text-slate-600 mb-2">کد تخفیف (اختیاری):</label>
                <input type="text" name="coupon_code" placeholder="اگر کد تخفیف داری اینجا وارد کن..." 
                       class="form-control w-full bg-white border border-slate-200 rounded-xl p-2.5 text-xs font-medium text-slate-700 focus:outline-none focus:border-blue-500 uppercase text-center">
            </div>

            <button type="submit" class="w-full btn btn-success fw-bold py-3 mt-4" style="background-color: #10b981; border: none; border-radius: 8px;">
                اتصال به درگاه زرین‌پال و پرداخت آنلاین
            </button>
             
        </form>
    </div>
</div>
@include('admin.layout.errors')
@endsection
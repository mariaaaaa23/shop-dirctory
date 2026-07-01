<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>وضعیت پرداخت سفارش</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://v1.fontapi.ir/css/vazir');
        body { font-family: 'Vazir', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100 transition-all transform hover:scale-[1.01]">
        
        @if($status == 'success')
            <div class="bg-emerald-500 p-8 flex flex-col items-center justify-center text-white relative">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mb-3 animate-bounce">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold">پرداخت با موفقیت انجام شد!</h1>
                <p class="text-emerald-100 text-sm mt-1">سفارش شما با موفقیت در سیستم ثبت گردید.</p>
            </div>
        @else
            <div class="bg-rose-500 p-8 flex flex-col items-center justify-center text-white relative">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold">خطا در فرآیند پرداخت!</h1>
                <p class="text-rose-100 text-sm mt-1">متاسفانه تراکنش انجام نشد یا توسط کاربر لغو گردید.</p>
            </div>
        @endif

        <div class="p-6 space-y-6">
            <div class="bg-slate-50 rounded-xl p-4 space-y-3 text-slate-600 text-sm">
                <div class="flex justify-between items-center">
                    <span>مبلغ پرداختی:</span>
                    <span class="font-bold text-slate-800 text-base">{{ number_format($amount) }} تومان</span>
                </div>
                
                @if($status == 'success')
                    <div class="flex justify-between items-center border-t border-slate-200 pt-2">
                        <span>شماره سفارش:</span>
                        <span class="font-mono font-medium text-slate-700">#{{ $order_id }}</span>
                    </div>
                    <div class="flex justify-between items-center border-t border-slate-200 pt-2 bg-emerald-50/50 p-2 rounded-lg">
                        <span class="text-emerald-700 font-medium">کد پیگیری بانکی:</span>
                        <span class="font-mono font-bold text-emerald-700">{{ $tracking_code }}</span>
                    </div>
                @else
                    <div class="flex flex-col gap-1 border-t border-slate-200 pt-2">
                        <span class="text-rose-600 font-medium">علت خطا:</span>
                        <p class="text-slate-500 text-xs leading-relaxed">{{ $message ?? 'تراکنش ناموفق' }}</p>
                    </div>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ url('/') }}" class="flex-1 bg-slate-900 text-white text-center py-3 rounded-xl font-medium shadow-lg shadow-slate-900/20 hover:bg-slate-800 transition-colors text-sm">
                    بازگشت به صفحه اصلی
                </a>
                
                @if($status == 'failed')
                    <a href="{{ url('/checkout') }}" class="flex-1 bg-white text-slate-700 text-center py-3 rounded-xl font-medium border border-slate-200 hover:bg-slate-50 transition-colors text-sm"></a>
                    @endif
                    </div>
                    </div>
                    </div>
                </body>
                </html>
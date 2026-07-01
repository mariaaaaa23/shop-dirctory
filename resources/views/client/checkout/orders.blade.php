<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سفارشات من</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://v1.fontapi.ir/css/vazir');
        body { font-family: 'Vazir', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 p-6">

    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-md p-6 border border-slate-100">
        <h1 class="text-xl font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4">تاریخچه سفارشات من</h1>

        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="text-slate-500 text-sm border-b border-slate-200">
                        <th class="pb-3">شماره سفارش</th>
                        <th class="pb-3">مبلغ کل</th>
                        <th class="pb-3">وضعیت سفارش</th>
                        <th class="pb-3">کد پیگیری</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 text-sm">
                    @foreach($orders as $order)
                        <tr>
                            <td class="py-4 font-mono">#{{ $order->id }}</td>
                            <td class="py-4 font-bold">{{ number_format($order->total_amount) }} تومان</td>
                            <td class="py-4">
                                
                                    @if($order->status == 'paid')
                                        <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-medium">پرداخت شده / در حال بررسی ادمین</span>
                                    @elseif($order->status == 'pending')
                                        <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-medium">در انتظار پرداخت</span>
                                    @elseif($order->status == 'shipped')
                                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">🚀 ارسال شده</span>
                                    @else
                                        <span class="bg-rose-100 text-rose-700 px-3 py-1 rounded-full text-xs font-medium">ناموفق / لغو شده</span>
                                    @endif
                                
                            </td>
                            <td class="py-4 font-mono font-medium text-slate-700">
                                @if($order->tracking_code)
                                    <span class="bg-slate-100 text-slate-800 px-2.5 py-1 rounded-lg text-xs font-bold tracking-wider">
                                        {{ $order->tracking_code }}
                                    </span>
                                @else
                                    <span class="text-slate-400 text-xs">در انتظار صدور...</span>
                                @endif
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ url('/') }}" class="inline-block bg-slate-900 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-800 transition-colors">
                بازگشت به فروشگاه
            </a>
        </div>
    </div>

</body>
</html>
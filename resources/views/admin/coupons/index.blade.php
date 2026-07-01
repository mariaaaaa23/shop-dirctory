@extends('admin.layout.master') <!-- یا هر لایه اصلی که برای ادمین داری -->

@section('content')
<div class="p-6 text-right" dir="rtl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-slate-800">📦 مدیریت کدهای تخفیف</h1>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm h-fit">
            <h2 class="text-sm font-bold text-slate-700 mb-4 border-b border-slate-50 pb-2">➕ ایجاد کد تخفیف جدید</h2>
            
            <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- عنوان/کد تخفیف -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-2">عبارت کد تخفیف (مثلاً: OFF20)</label>
                    <input type="text" name="code" placeholder="OFF20" required
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs font-medium text-slate-700 focus:outline-none focus:border-blue-500 uppercase text-center">
                </div>

                <!-- درصد تخفیف -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-2">درصد تخفیف</label>
                    <input type="number" name="percent" min="1" max="100" placeholder="20" required
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs font-medium text-slate-700 focus:outline-none focus:border-blue-500 text-center">
                </div>

                <!-- تاریخ انقضا -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-2">تاریخ انقضا</label>
                    <input type="datetime-local" name="expires_at" required
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs font-medium text-slate-700 focus:outline-none focus:border-blue-500 text-center">
                </div>

                <!-- دکمه ثبت -->
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-dark p-3 rounded-xl text-xs font-bold transition-all shadow-sm cursor-pointer mt-2">
                    ذخیره و انتشار کد تخفیف
                </button>
            </form>
        </div>

        <!-- 📊 لیست کدهای تخفیف موجود -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <h2 class="text-sm font-bold text-slate-700 mb-4 border-b border-slate-50 pb-2">📋 کدهای فعال و منقضی شده</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-right text-slate-600">
                    <thead class="text-xs text-slate-400 bg-slate-50/50 rounded-xl">
                        <tr>
                            <th class="p-3 text-center">کد تخفیف</th>
                            <th class="p-3 text-center">درصد</th>
                            <th class="p-3 text-center">تاریخ انقضا</th>
                            <th class="p-3 text-center">وضعیت</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($coupons ?? [] as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="p-3 font-bold text-center text-slate-800 uppercase">{{ $item->code }}
                                </td>
                                <td class="p-3 text-center font-medium text-emerald-600">{{ $item->percent }}٪</td>
                                <td class="p-3 text-center text-xs dir-ltr">{{ $item->expires_at }}</td>
                                <td class="p-3 text-center">
                                    @if($item->isValid())
                                        <span class="bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full text-[10px] font-bold">فعال</span>
                                    @else
                                        <span class="bg-rose-50 text-rose-700 px-2.5 py-1 rounded-full text-[10px] font-bold">منقضی/غیرفعال</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-xs text-slate-400">هیچ کد تخفیفی تاکنون ثبت نشده است.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('admin.layout.errors')
@endsection
@extends('admin.layout.master') 

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-danger">گزارش‌های تخلف بررسی نشده</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($reports->isEmpty())
                <div class="alert alert-info mb-0">هیچ گزارش تخلفی ثبت نشده است.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>گزارش دهنده</th>
                                <th>آگهی گزارش شده</th>
                                <th>علت تخلف</th>
                                <th>توضیحات تکمیلی</th>
                                <th>تاریخ ثبت</th>
                                <th>عملیات مدیریت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                                <tr>
                                    <!-- کاربری که گزارش را ثبت کرده -->
                                    <td>{{ $report->user->name }}</td>
                                    
                                    <!-- لینک یا عنوان آگهی متخلف -->
                                    <td>
                                        @if($report->product)
                                            <a href="#" class="text-decoration-none fw-bold">
                                                {{ $report->product->name }}
                                            </a>
                                            <br>
                                            <small class="text-muted">شناسه آگهی: {{ $report->product_id }}</small>
                                        @else
                                            <span class="text-muted">آگهی قبلاً حذف شده</span>
                                        @endif
                                    </td>
                                    
                                    <!-- علت گزارش -->
                                    <td>
                                        <span class="badge bg-warning text-dark px-2.5 py-1.5">{{ $report->reason }}</span>
                                    </td>
                                    
                                    <!-- توضیحات -->
                                    <td>
                                        <p class="small mb-0 text-secondary" style="max-width: 200px;">
                                            {{ $report->description ?? 'بدون توضیحات' }}
                                        </p>
                                    </td>
                                    
                                    <!-- زمان ثبت -->
                                    <td>{{ $report->created_at->diffForHumans() }}</td>
                                    
                                    <!-- دکمه‌های عملیاتی ادمین -->
                                    <td>
                                        <div class="d-flex gap-2">
                                            @if($report->product)
                                                <!-- ۱. فرم و دکمه حذف آگهی -->
                                                <form action="{{ route('admin.products.destroy', $report->product_id) }}" method="POST" onsubmit="return confirm('آیا از حذف این آگهی مطمئن هستید؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">حذف آگهی</button>
                                                </form>

                                                <!-- ۲. فرم و دکمه مسدود سازی نویسنده آگهی -->
                                                <form action="{{ route('admin.users.block', $report->product->user_id) }}" method="POST" onsubmit="return confirm('آیا از مسدود کردن این کاربر اطمینان دارید؟')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-danger">مسدودسازی کاربر</button>
                                                </form>
                                            @endif

                                            <!-- . دکمه دیده‌شدن و بایگانی گزارش (در صورتی که تخلفی نبوده) -->
                                            <form action="{{ route('admin.reports.seen', $report->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-light text-muted">رد گزارش</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- لینک‌های صفحه‌بندی -->
                <div class="mt-3">
                    {{ $reports->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
@extends('client.layout.master')

@section('content')
<div class="container mt-5" dir="rtl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>لیست آگهی‌های شما</h2>
        <a href="{{ route('author.products.create') }}" class="btn btn-primary">➕ ثبت آگهی جدید</a>
    </div>

    {{-- نمایش پیام‌های موفقیت‌آمیز (مثل حذف یا ویرایش موفق) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 text-center vertical-align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 80px;">تصویر</th>
                            <th scope="col">عنوان آگهی</th>
                            <th scope="col">دسته‌بندی</th>
                            <th scope="col">موقعیت</th>
                            <th scope="col">قیمت (تومان)</th>
                            <th scope="col">وضعیت آگهی</th> 
                            <th scope="col" style="width: 250px;">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="60" height="60" class="rounded border object-fit-cover">
                                    @else
                                        <span class="text-muted">بدون تصویر</span>
                                    @endif
                                </td>

                                <td class="fw-bold">{{ $product->name }}</td>

                                <td>{{ $product->category->title ?? '---' }}</td>

                                <td>
                                    @if($product->city)
                                        {{ $product->city->state->name ?? '' }}، {{ $product->city->name }}
                                    @else
                                        <span class="text-muted">نامشخص</span>
                                    @endif
                                </td>

                                <td class="text-dark fw-bold">
                                    {{ number_format($product->cost) }}
                                </td>

                                <td>
                                    @if($product->status == 'pending')
                                        <span class="badge bg-warning text-dark px-2 py-1.5" style="font-size: 0.85rem;"> در حال بررسی</span>
                                    @elseif($product->status == 'approved')
                                        <span class="badge bg-dark px-2 py-1.5" style="font-size: 0.85rem;"> منتشر شده</span>
                                    @elseif($product->status == 'rejected')
                                        <span class="badge bg-dark px-2 py-1.5" style="font-size: 0.85rem;"> رد شده</span>
                                    @endif
                                </td>

                                <td>
                                    @if($product->status == 'approved')
                                        <a href="{{ route('client.products.show', $product->slug) }}" class="btn btn-sm btn-outline-info" title="مشاهده در سایت"> سایت</a>
                                    @else
                                        <button class="btn btn-sm btn-outline-secondary" disabled title="آگهی هنوز تایید نشده است"> سایت</button>
                                    @endif

                                    <a href="{{ route('author.products.edit', $product->id) }}" class="btn btn-sm btn-warning mx-1"> ویرایش</a>

                                    <form action="{{ route('author.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا از حذف این آگهی مطمئن هستید؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"> حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <p class="mb-0 fs-5">شما هنوز هیچ آگهی ثبت نکرده‌اید.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('admin.layout.master')

@section('content')
<div class="container-fluid pt-4">
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">مدیریت تنوع رنگ و قیمت برای محصول: <span class="text-primary">{{ $product->title }}</span></h3>
            
            {{-- نمایش پیام موفقیت --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- فرم ثبت تنوع جدید --}}
            <div class="card mb-4 text-end" dir="rtl">
                <div class="card-header bg-primary text-white">افزودن تنوع رنگی جدید</div>
                <div class="card-body">
                    <form action="{{ route('admin.products.variations.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">نام رنگ (مثل: صورتی، آبی)</label>
                                <input type="text" name="color_name" class="form-control" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">کد رنگ (مثلاً: #ff0000)</label>
                                <input type="color" name="color_code" class="form-control" style="height: 38px;">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">قیمت مخصوص این رنگ (تومان)</label>
                                <input type="number" name="price" class="form-control" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">تعداد موجودی</label>
                                <input type="number" name="stock" class="form-control" value="10" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">عکس اختصاصی این رنگ</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mt-2">ثبت تنوع جدید</button>
                    </form>
                </div>
            </div>

            {{-- جدول نمایش تنوع‌های ثبت شده --}}
            <div class="card text-end" dir="rtl">
                <div class="card-header bg-secondary text-white">لیست تنوع‌های موجود این محصول</div>
                <div class="card-body">
                    <table class="table table-bordered table-striped text-center align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام رنگ</th>
                                <th>نمایش رنگ</th>
                                <th>قیمت (تومان)</th>
                                <th>موجودی</th>
                                <th>تصویر</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($product->variations as $variation)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $variation->color_name }}</td>
                                    <td>
                                        <div style="width: 25px; height: 25px; border-radius: 50%; background-color: {{ $variation->color_code }}; margin: 0 auto; border: 1px solid #ccc;"></div>
                                    </td>
                                    <td>{{ number_format($variation->price) }}</td>
                                    <td>{{ $variation->stock }}</td>
                                    <td>
                                        @if($variation->image)
                                            <img src="{{ asset('storage/' . $variation->image) }}" width="60" class="img-thumbnail">
                                        @else
                                            <span class="text-muted">بدون عکس</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.products.variations.destroy', $variation->id) }}" method="POST" onsubmit="return confirm('آیا از حذف این رنگ مطمئن هستید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">هنوز هیچ تنوع رنگی برای این محصول ثبت نشده است.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@extends('client.layout.master')

@section('content')
<div class="container my-5 text-end" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <h3 class="mb-4 fw-bold">مدیریت تنوع رنگ و قیمت برای محصول: <span class="text-primary">{{ $product->name }}</span></h3>

            {{-- نمایش پیام موفقیت --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- فرم ثبت تنوع جدید --}}
            <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">🎨 افزودن تنوع رنگی جدید</h5>
                </div>
                <div class="card-body bg-light">
                    <form action="{{ route('author.products.variations.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row align-items-end"> {{-- تراز شدن فیلدها در یک خط افقی --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label small text-muted fw-bold">نام رنگ (مثل: صورتی، آبی)</label>
                                <input type="text" name="color_name" class="form-control" required placeholder="نام رنگ...">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label small text-muted fw-bold">کد رنگ</label>
                                <input type="color" name="color_code" class="form-control" style="height: 38px; padding: 2px;">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label small text-muted fw-bold">قیمت مخصوص این رنگ (تومان)</label>
                                <input type="number" name="price" class="form-control" required placeholder="قیمت...">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label small text-muted fw-bold">تعداد موجودی</label>
                                <input type="number" name="stock" class="form-control" value="10" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label small text-muted fw-bold">عکس اختصاصی رنگ</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                        
                          {{-- دکمه‌های راست‌چین شده با کلاس‌های ترازکننده قدرتمند --}}
                       <div class="d-flex justify-content-start align-items-center gap-2 mt-4" dir="rtl">
                         <button type="submit" class="btn btn-success btn-sm px-4 py-2">ثبت تنوع جدید</button>
                         <a href="{{ route('author.products.index') }}" class="btn btn-outline-secondary btn-sm px-4 py-2">انصراف</a>
                     </div>
                    </form>
                </div>
            </div>

            {{-- جدول نمایش تنوع‌های ثبت شده --}}
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-secondary text-white py-3">
                    <h5 class="mb-0 fw-bold">📋 لیست تنوع‌های موجود این محصول</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover text-center align-middle mb-0">
                        <thead class="table-dark">
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
                                    <td class="fw-bold">{{ $variation->color_name }}</td>
                                    <td>
                                        <div style="width: 24px; height: 24px; border-radius: 50%; background-color: {{ $variation->color_code }}; margin: 0 auto; border: 1px solid #ccc; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"></div>
                                    </td>
                                    <td class="text-dark fw-bold">{{ number_format($variation->price) }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-2 py-1">{{ $variation->stock }}</span>
                                    </td>
                                    <td>
                                        @if($variation->image)
                                            <img src="{{ asset('storage/' . $variation->image) }}" width="50" class="img-thumbnail rounded">
                                        @else
                                            <span class="text-muted small">بدون عکس</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('author.variations.destroy', $variation->id) }}" method="POST" onsubmit="return confirm('آیا از حذف این رنگ مطمئن هستید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fa fa-trash"></i> حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-muted py-4 small">هنوز هیچ تنوع رنگی برای این محصول ثبت نشده است.</td>
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
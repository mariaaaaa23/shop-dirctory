@extends('client.layout.master')

@section('content')
<div class="container my-5 text-end" dir="rtl">
    
    <h3 class="mb-4 fw-bold">مدیریت گالری تصاویر محصول: <span class="text-primary">{{ $product->name }}</span></h3>

    {{-- نمایش پیام موفقیت سیستم --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

    {{-- فرم آپلود تصویر --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">📸 آپلود تصویر جدید برای آگهی</h5>
                </div>
                <div class="card-body bg-light">
                    {{-- اصلاح املای کلمه author در روت استور --}}
                    <form action="{{ route('author.products.gallery.store', $product->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-md-6 mb-3">
                                <label for="path" class="form-label small text-muted fw-bold">انتخاب فایل تصویر</label>
                                <input type="file" name="path" class="form-control" required>  
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-success btn-sm px-4 py-2">آپلود تصویر</button>
                                    <a href="{{ route('author.products.index') }}" class="btn btn-outline-secondary btn-sm px-4 py-2">بازگشت</a>
                                </div>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </div>

    {{-- نمایش گالری محصولات افقی --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-secondary text-white py-3">
            <h5 class="mb-0 fw-bold">📋 تصاویر ثبت شده فعلی</h5>
        </div>
        <div class="card-body bg-white py-4">
            <div class="d-flex flex-row flex-nowrap overflow-auto" style="gap:15px; padding-bottom:10px;">
                @forelse ($product->pictures as $picture)
                <div style="
                    min-width:220px;
                    background:#ffffff;
                    border-radius:12px;
                    box-shadow:0 4px 15px rgba(0,0,0,0.08);
                    overflow:hidden;
                    border: 1px solid #eee;
                ">
                    <img src="{{ asset('storage/' . $picture->path) }}" alt="product"
                         style="width:100%; height:160px; object-fit:cover;">

                    <div style="padding:12px;" class="text-center">
                       <form action="{{ route('author.products.gallery.destroy', ['product' => $product->id, 'gallery' => $picture->id]) }}" method="post" onsubmit="return confirm('آیا از حذف این تصویر مطمئن هستید؟')">
                           @csrf
                           @method('DELETE')
                           <button type="submit" class="btn btn-sm btn-outline-danger w-100">حذف تصویر</button>
                       </form>
                    </div>
                </div>
                @empty
                <div class="text-muted small py-3 pr-3 w-100 text-center">هنوز هیچ تصویری برای این آگهی آپلود نشده است.</div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
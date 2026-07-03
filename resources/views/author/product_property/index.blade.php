@extends('client.layout.master') {{-- حتماً نام لایوت اصلی فرانت خودت را جایگزین کن --}}

@section('content')
<div class="container my-5 text-end" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            {{-- پیام موفقیت --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- کارت اول: فرم مدیریت ویژگی‌ها در بالای صفحه --}}
            <div class="card shadow-sm mb-4 border-0 rounded-3">
                <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">⚙️ مدیریت ویژگی‌های آگهی: {{ $product->name }}</h5>
                    <a href="{{ route('author.products.index') }}" class="btn btn-light btn-sm">بازگشت به آگهی‌ها</a>
                </div>
                <div class="card-body bg-light">
                    <form action="{{ route('author.products.properties.store', $product->id) }}" method="post">
                        @csrf
                        
                        @forelse ($propertyGroups as $group)
                            <h6 class="mt-3 text-primary fw-bold border-bottom pb-2">{{ $group->title }}</h6>
                            <div class="row">
                                @foreach ($group->properties as $property)
                                    <div class="col-md-6 mb-3">
                                        <div class="row align-items-center">
                                            <div class="col-3">
                                                <label class="form-label mb-0 small text-muted">{{ $property->title }}</label>
                                            </div>
                                            <div class="col-9">
                                                <input type="text" class="form-control" 
                                                       name="properties[{{ $property->id }}][value]" 
                                                       value="{{ $property->getValueForProduct($product) }}"
                                                       placeholder="مقدار را وارد کنید...">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @empty
                            <div class="alert alert-warning text-center small">هیچ گروه ویژگی برای این دسته‌بندی تعریف نشده است.</div>
                        @endforelse

                        <div class="text-start mt-3">
                            <a href="{{ route('author.products.index') }}" class="btn btn-outline-secondary btn-sm me-2">انصراف</a>
                            <button type="submit" class="btn btn-success btn-sm px-4">ذخیره مشخصات</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- کارت دوم: نمایش جدول ویژگی‌های فعلی ثبت شده در پایین صفحه --}}
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-secondary text-white py-3">
                    <h5 class="mb-0 fw-bold">📋 مشخصات ثبت شده فعلی</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover text-center align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 15%">#</th>
                                <th>نام ویژگی</th>
                                <th>مقدار ثبت شده</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($product->properties as $property)
                                <tr><td>{{ $property->id }}</td>
                                    <td class="fw-bold">{{ $property->title }}</td>
                                    <td>
                                        <span class="badge bg-info text-white px-3 py-2">
                                            {{ $property->pivot->value }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-muted py-4 small">هنوز مشخصاتی برای این آگهی ثبت نشده است</td>
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
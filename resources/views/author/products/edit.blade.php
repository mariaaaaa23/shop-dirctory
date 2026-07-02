@extends('client.layout.master')

@section('content')
<div class="container mt-5" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-8 text-end">
            
            <h2 class="mb-4">ویرایش آگهی</h2>
            
            {{-- نمایش خطاهای ولیدیشن در صورت وجود --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- اکشن فرم به روت update متصل می‌شود و آیدی محصول را می‌فرستد --}}
            <form action="{{ route('author.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- دسته بندی --}}
                <div class="form-group mb-3">
                    <label for="category_id">دسته بندی </label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="" disabled>دسته بندی را انتخاب کنید</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- برند --}}
                <div class="form-group mb-3">
                    <label for="brand_id">برند</label>
                    <select name="brand_id" id="brand_id" class="form-control">
                        <option value="" disabled>برند محصول را انتخاب کنید</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- استان --}}
                <div class="form-group mb-3">
                    <label for="province">استان</label>
                    <select id="province" name="province_id" class="form-control">
                        <option value="" disabled {{ !$product->city ? 'selected' : '' }}>استان مورد نظر را انتخاب کنید</option>
                        @foreach ($provinces as $province)
                            @php
                                $productProvinceId = $product->city ? ($product->city->province_id ?? $product->city->state_id) : null;
                            @endphp
                            <option value="{{ $province->id }}" {{ $productProvinceId == $province->id ? 'selected' : '' }}>
                                {{ $province->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- شهر --}}
                <div class="form-group mb-3">
                    <label for="city">شهر</label>
                    {{-- ویژگی disabled حذف شد و آیدی تگ با جاوااسکریپت هماهنگ شد --}}
                    <select name="city_id" id="city" class="form-control">
                        @if($product->city)
                            <option value="{{ $product->city_id }}" selected>{{ $product->city->name }}</option>
                        @else
                            <option value="" disabled selected>ابتدا استان را انتخاب کنید</option>
                        @endif
                    </select>
                </div>

                {{-- عنوان آگهی --}}
                <div class="mb-3">
                    <label for="name" class="form-label">عنوان آگهی</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $product->name) }}" required>
                </div>

                {{-- اسلاگ --}}
                <div class="mb-3">
                    <label for="slug" class="form-label">اسلاگ</label>
                    <input type="text" name="slug" class="form-control" id="slug" value="{{ old('slug', $product->slug) }}" required>
                </div>

                {{-- توضیحات --}}
                <div class="mb-3">
                    <label for="description" class="form-label">توضیحات</label>
                    <textarea name="description" class="form-control" id="description" rows="5" required>{{ old('description', $product->description) }}</textarea>
                </div>

                {{-- قیمت --}}
                <div class="mb-3">
                    <label for="cost" class="form-label">قیمت (تومان)</label>
                    <input type="number" name="cost" class="form-control" id="cost" value="{{ old('cost', $product->cost) }}" required>
                </div>

                {{-- تصویر آگهی --}}
                <div class="mb-3">
                    <label for="image" class="form-label">تصویر آگهی</label>
                    <input type="file" name="image" class="form-control mb-2" id="image" accept="image/*">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="تصویر فعلی آگهی" width="120" class="rounded border">
                    @endif
                </div>

                <button type="submit" class="btn btn-success">بروزرسانی و ارسال به صف تایید</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // ۱. بررسی مقدار اولیه استان و شهر برای حالت ویرایش
    var initialStateId = $('#province').val();
    var currentCityId = "{{ $product->city_id ?? '' }}";

    // فعال‌سازی اولیه بر اساس دیتای فعلی محصول
    if (!initialStateId || initialStateId === "") {
        $('#city').prop('disabled', true);
        forceRefreshMenu($('#city'));
    } else {
        loadAuthorCities(initialStateId, currentCityId);
    }

    // ۲. شنود تغییر دستی استان
    $('#province').on('change', function () {
        var provinceId = $(this).val();
        loadAuthorCities(provinceId, null);
    });

    function loadAuthorCities(provinceId, selectedCityId) {
        var citySelect = $('#city');

        if (!provinceId || provinceId === "" || provinceId === undefined) {
            citySelect.html('<option value="">ابتدا استان را انتخاب کنید</option>');
            citySelect.prop('disabled', true);
            forceRefreshMenu(citySelect);
            return;
        }

        citySelect.html('<option value="">در حال بارگذاری...</option>');
        citySelect.prop('disabled', true);
        forceRefreshMenu(citySelect);

        $.ajax({
            url: '/author/get-cities/' + provinceId, 
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                citySelect.empty();
                citySelect.prop('disabled', false); // باز کردن قفل تگ برای تعامل کاربر
                
                var citiesArray = Array.isArray(data) ? data : Object.values(data);

                if (citiesArray.length > 0) {
                    citySelect.append('<option value="">انتخاب شهر</option>');
                    $.each(citiesArray, function (key, city) {
                        if (city && city.id) {
                            var isSelected = (selectedCityId && String(city.id) === String(selectedCityId)) ? 'selected' : '';
                            citySelect.append('<option value="' + city.id + '" ' + isSelected + '>' + city.name + '</option>');
                        }
                    });
                } else {
                    citySelect.append('<option value="">شهری برای این استان یافت نشد</option>');
                }

                // بازسازی لایه ظاهری پوسته قالب
                forceRefreshMenu(citySelect);
            },
            error: function (xhr, status, error) {
                console.error("خطا در پاسخ سرور:", xhr.responseText);
                citySelect.html('<option value="">خطا در بارگذاری اطلاعات</option>');
                citySelect.prop('disabled', true);
                forceRefreshMenu(citySelect);
            }
        });
    }

    function forceRefreshMenu(element) {
        try {
            if ($.isFunction($.fn.niceSelect)) {
                element.niceSelect('update');
            }
            element.trigger('change.selectric');
            element.trigger('chosen:updated');
            element.trigger('change');
        } catch (e) {
            console.log("تلاش برای بروزرسانی ظاهر منو انجام شد.");
        }
    }
});
</script>
@endsection
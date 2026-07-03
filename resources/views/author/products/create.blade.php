@extends('client.layout.master')

@section('content')
<div class="container mt-5" dir="rtl">
    <h2>ثبت آگهی جدید </h2>
    
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


    <form action="{{ route('author.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{--  وقتی میخواییم محصول ایجاد کنیم باید دسته بندی اش را انتخاب کنیم --}}
        <div class="form-group">
            <label for="category_id">دسته بندی </label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="" disabled selected>دسته بندی را انتخاب کنید</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>
        </div>

        {{--  وقتی میخواییم محصول ایجاد کنیم باید برندش را انتخاب کنیم --}}
        <div class="form-group">
            <label for="brand_id">برند</label>
            <select name="brand_id" id="brand_id" class="form-control">
                <option value="" disabled selected>برند محصول را انتخاب کنید</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="province">استان</label>
            <select id="province" name="province_id" class="form-control">
                <option value="">انتخاب استان</option>
                @foreach($provinces as $province)
                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group mt-3">
            <label for="city">شهر</label>
            {{-- ویژگی disabled از اینجا حذف شد تا پلاگین‌ها آن را در حالت قفل ابدی لود نکنند --}}
            <select id="city" name="city_id" class="form-control">
                <option value="">ابتدا استان را انتخاب کنید</option>
            </select>
        </div>
    
        <div class="mb-3">
            <label for="name" class="form-label">عنوان آگهی</label>
            <input type="text" name="name" class="form-label form-control" id="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">اسلاگ</label>
            <input type="text" name="slug" class="form-label form-control" id="slug" value="{{ old('slug') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">توضیحات</label>
            <textarea name="description" class="form-control" id="description" rows="5" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="cost" class="form-label">قیمت (تومان)</label>
            <input type="number" name="cost" class="form-control" id="cost" value="{{ old('cost') }}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">تصویر آگهی</label>
            <input type="file" name="image" class="form-control" id="image" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">انتشار آگهی</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    var initialStateId = $('#province').val();
    var currentCityId = "{{ isset($product) ? $product->city_id : '' }}";

    // فعال‌سازی یا غیرفعال‌سازی اولیه منوی شهر متناسب با مقدار استان در بدو ورود
    if (!initialStateId || initialStateId === "") {
        $('#city').prop('disabled', true);
        forceRefreshMenu($('#city'));
    } else {
        loadAuthorCities(initialStateId, currentCityId);
    }

    $('#province').on('change', function () {
        var provinceId = $(this).val();
        loadAuthorCities(provinceId, null);
    });

    function loadAuthorCities(provinceId, selectedCityId) {
        var citySelect = $('#city');

        if (!provinceId || provinceId === "" || provinceId === undefined) {
            citySelect.html('<option value="">ابتدا استان را انتخاب کنید</option>');
            citySelect.prop('disabled', true); // غیرفعال کردن پویا
            forceRefreshMenu(citySelect);
            return;
        }

        citySelect.html('<option value="">در حال بارگذاری...</option>');
        citySelect.prop('disabled', true); // قفل موقت در حین دانلود اطلاعات
        forceRefreshMenu(citySelect);

        $.ajax({
            url: '/get-cities/' + provinceId, 
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                citySelect.empty();
                
                // باز کردن قفل تگ برای پذیرش دیتای جدید و تعامل کاربر
                citySelect.prop('disabled', false); 
                
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

                // بازسازی نهایی ظاهر منوی کشویی بعد از لود کامل و فعال شدن منو
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
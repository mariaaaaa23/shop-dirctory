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

                 {{--  وقتی میخواییم محصول ایجاد کنیم باید دسته بندی اش را انتخاب کنیم --}}
                 <div class="form-grpup">
                    <label for="category_id">دسته بندی </label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="" disabled selected>دسته بندی را انتخاب کنید</option>

                        @foreach ($categories as $category )
                        <option
                        {{-- نمایش کتگوری از قبل انتخاب شده --}}
                        @if ($product->category_id == $category->id)
                            selected
                        @endif
                        value="{{ $category->id }}">{{ $category->title }}</option>
                            
                        @endforeach
                    </select>
                </div>


                 {{--  وقتی میخواییم محصول ایجاد کنیم باید برندش را انتخاب کنیم --}}
                 <div class="form-grpup">
                    <label for="brand_id">برند</label>
                    <select name="brand_id" id="brand_id" class="form-control">
                        <option value="" disabled selected>برند محصول را انتخاب کنید</option>
                        
                        @foreach ($brands as $brand )
                        <option 
                        {{-- نمایش برند های از قبل انتخاب شده --}}
                        @if ($product->brand_id == $brand->id)
                            selected
                        @endif
                        value="{{ $brand->id }}">{{ $brand->name }}</option>
                            
                        @endforeach
                        </select>
                </div>


                <div class="form-group">
                    <label for="province-select">استان</label>
                    <select id="province-select" class="form-control">
                        <option value="" disabled>استان مورد نظر را انتخاب کنید</option>
                        @foreach ($provinces as $province)
                            {{-- چک کردن استانِ شهرِ فعلی محصول برای selected شدن --}}
                            <option value="{{ $province->id }}" {{ ($product->city && $product->city->state_id == $province->id) ? 'selected' : '' }}>
                                {{ $province->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="city-select">شهر</label>
                    <select name="city_id" id="city-select" class="form-control">
                        @if($product->city)
                            {{-- اگر محصول از قبل شهر داشت، نام شهر را اینجا نشان بده --}}
                            <option value="{{ $product->city_id }}" selected>{{ $product->city->name }}</option>
                        @else
                            <option value="" disabled selected>ابتدا استان را انتخاب کنید</option>

                        @endif
                    </select>
                </div>




               {{-- ادامه‌ی فرم شما از بخش عنوان آگهی --}}
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

<!-- ⚡ اسکریپت AJAX برای لود پویای شهرها در صفحه ویرایش نویسنده -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
// ۱. لود اتوماتیک بقیه شهرهای استانِ فعلی محصول به محض باز شدن صفحه
var initialStateId = $('#province-select').val();
var currentCityId = "{{ $product->city_id }}";

if (initialStateId) {
    loadCities(initialStateId, currentCityId);
}

// ۲. وقتی نویسنده استان را به صورت دستی تغییر می‌دهد
$('#province-select').on('change', function () {
    loadCities(this.value, null);
});

// تابع کمکی ارسال درخواست AJAX
function loadCities(stateId, selectedCityId) {
    $('#city-select').html('<option value="" disabled selected>در حال بارگذاری شهرها...</option>');
    
    $.ajax({
        url: '/api/states/' + stateId + '/cities',
        type: 'GET',
        dataType: 'json',
        success: function (res) {
            $('#city-select').html('<option value="" disabled>شهر مورد نظر را انتخاب کنید</option>');
            $.each(res, function (key, city) {
                var isSelected = (selectedCityId && city.id == selectedCityId) ? 'selected' : '';
                $('#city-select').append('<option value="' + city.id + '" ' + isSelected + '>' + city.name + '</option>');
            });
        }
    });
}
});
</script>
@endsection
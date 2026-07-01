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

                @foreach ($categories as $category )
                <option value="{{ $category->id }}">{{ $category->title }}</option>
                    
                @endforeach
            </select>
        </div>

        


          {{--  وقتی میخواییم محصول ایجاد کنیم باید برندش را انتخاب کنیم --}}
          <div class="form-group">
            <label for="brand_id">برند</label>
            <select name="brand_id" id="brand_id" class="form-control">
                <option value="" disabled selected>برند محصول را انتخاب کنید</option>
                
                @foreach ($brands as $brand )
                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    
                @endforeach
                </select>
        </div>


        <div class="form-group">
            <label for="province-select">استان</label>
            <select id="province-select" class="form-control">
                <option value="" disabled selected>استان مورد نظر را انتخاب کنید</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="city-select">شهر</label>
            <select name="city_id" id="city-select" class="form-control" disabled>
                <option value="" disabled selected>ابتدا استان را انتخاب کنید</option>
            </select>
        </div>

       
        <div class="mb-3">
            <label for="name" class="form-label">عنوان آگهی</label>
            <input type="text" name="name" class="form-label form-control" id="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">اسلاگ</label>
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
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('#province-select').on('change', function () {
        var stateId = this.value;
        
        // غیرفعال کردن موقت کادر شهر و نمایش متن بارگذاری
        $('#city-select').html('<option value="" disabled selected>در حال بارگذاری شهرها...</option>').prop('disabled', true);
        
        if (stateId) {
            $.ajax({
                url: '/api/states/' + stateId + '/cities',
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    $('#city-select').html('<option value="" disabled selected>شهر مورد نظر را انتخاب کنید</option>').prop('disabled', false);
                    $.each(res, function (key, city) {
                        $('#city-select').append('<option value="' + city.id + '">' + city.name + '</option>');
                    });
                },
                error: function() {
                    $('#city-select').html('<option value="" disabled selected>خطا در بارگذاری اطلاعات!</option>');
                }
            });
        } else {
            $('#city-select').html('<option value="" disabled selected>ابتدا استان را انتخاب کنید</option>').prop('disabled', true);
        }
    });
});
</script>
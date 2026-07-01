@extends('admin.layout.master')


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">ویرایش محصول {{ $product->name }}</h2>
                </div>

                <div class="card-body">

                    {{-- enctype="multipart/form-data"  یعنی فرمی که چند بخشی هست  برای اینکه فایلی رو آپلود کنیم بفرستیم سمت سرور--}}
                    <form action="{{ route('admin.products.update', $product) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')


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

                        




                        <div class="form-group">
                           <label for="name">نام</label>
                           <input type="text" class="form-control" name="name" id="title" value="{{ $product->name }}">
                        </div>


                        <div class="form-group">
                            <label for="title">اسلاگ</label>
                            <input type="text" class="form-control" name="slug" id="slug" value="{{ $product->slug }}" >
                        </div>


                        <div class="form-group">
                            <label for="title">قیمت</label>
                            <input type="text" class="form-control" name="cost" id="price" value="{{ $product->cost }}" >
                        </div>



                        


                        {{-- فرم برای آپلود تصویر --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="image">تصویر</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>
                                {{-- نمایش تصویر --}}
                                <div class="col-sm-6">
                                    <img src="{{ asset('storage/' . $product->image) }}" width="100" alt="">
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="descripion">توضیحات</label>
                            <textarea name="description" id="description" class="form-control">{{ $product->description }}</textarea>
                        </div>


                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" value="ثبت" class="btn btn-primary">
                        </div>
                        
                    </form>

                </div>
            </div>

        @include('admin.layout.errors')

        </div>
    </div>

@endsection



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // ۱. وقتی صفحه ادیت لود می‌شود، شهرهای استان فعلی را به صورت اتوماتیک لود کن
    var initialStateId = $('#province-select').val();
    var currentCityId = "{{ $product->city_id }}";

    if (initialStateId) {
        loadCities(initialStateId, currentCityId);
    }

    // ۲. وقتی ادمین به صورت دستی استان را تغییر می‌دهد
    $('#province-select').on('change', function () {
        loadCities(this.value, null);
    });

    // تابع کمکی برای ارسال درخواست AJAX
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



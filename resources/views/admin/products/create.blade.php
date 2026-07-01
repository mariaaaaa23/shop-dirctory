@extends('admin.layout.master')


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">ایجاد محصول</h2>
                </div>

                <div class="card-body">

                    {{-- enctype="multipart/form-data"  یعنی فرمی که چند بخشی هست  برای اینکه فایلی رو آپلود کنیم بفرستیم سمت سرور--}}
                    <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
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
                           <label for="name">نام</label>
                           <input type="text" class="form-control" name="name" id="name">
                        </div>
                        

                    


                        <div class="form-group">
                            <label for="slug">اسلاگ</label>
                            <input type="text" class="form-control" name="slug" id="slug">
                         </div>


                         <div class="form-group">
                            <label for="price">قیمت</label>
                            <input type="number" class="form-control" name="cost" id="cost">
                         </div>





                        {{-- فرم برای آپلود تصویر --}}
                        <div class="form-group">
                            <label for="image">تصویر</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>


                    <div class="form-group">
                        <label for="description">توضیحات</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
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


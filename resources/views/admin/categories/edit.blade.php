@extends('admin.layout.master')

@section('content')

<section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"> ویرایش دسته بندی  </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

          


                <form action="{{ route('admin.categories.update',$category) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="form-grou">
                        <label for="category_id">دسته والد</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="" disabled selected>دسته والد را انتخاب کنید...</option>
                            @foreach ($categories as $parent )
                            {{-- از parent استفاده میکنیم چون وقتی میخواییم ویرایشش کنیم با کتگوری اصلی اشتباه نشه --}}
                                <option 
                                {{-- اگر کتگوری که میخواییم ویرایش کنیم خودش دسته والد داشت بهمون نمایش بده --}}
                                @if ($parent->id == $category->category_id)
                                    selected
                                @endif
                                value="{{ $parent->id }}">{{ $parent->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                       <label for="title">عنوان</label>
                       <input type="text" class="form-control" name="title" id="title" value="{{ $category->title }}">
                    </div>


                    {{--  چک باکس برای انتخاب ویژگی ها --}}
                    <div class="form-group">
                        <label>انتخاب گروه ویژگی ها</label>
                        <div class="row">
                            @foreach ($properties as $property)
                                <lable class="col-sm-2">
                                    <input 
                                       {{-- اگه برای این دسته بندی ویژگی وجود داشته باشه یا انتخاب شده باشه چک میکنه --}}
                                      @if ($category->hasPropertyGroup($property))
                                         checked
                                      @endif
                                    type="checkbox" name="properties[]" value="{{ $property->id }}">{{ $property->title }}
                                </lable>
                            @endforeach
                        </div>
                    </div>

                    



                <div class="form-group">
                    <label for="title">اسلاگ</label>
                    <input type="text" class="form-control" name="slug" id="slug" value="{{ $category->slug }}" >
                </div>


                <div class="form-group">
                    <input type="submit" name="submit" id="submit" value="ثبت" class="btn btn-primary">
                </div>


            </form>

        </div>
        @include('admin.layout.errors')
        @include('admin.layout.notification')
@endsection
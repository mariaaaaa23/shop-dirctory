@extends('admin.layout.master')

@section('content')

<section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"> ایجاد دسته بندی  </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            <form action="{{ route('admin.categories.store') }}" method="post">
                @csrf
                
                <div class="form-group">
                    <label for="caregory_id">دسته والد</label>
                    <select name="category_id" id="category_id" class="form-controller">
                        <option value="" disabled selected>دسته والد را انتخاب کنید...</option>
                        @foreach ($categories as $category )
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>



                {{--  چک باکس برای انتخاب ویژگی ها --}}
                <div class="form-group">
                    <label>انتخاب گروه ویژگی ها</label>
                    <div class="row">
                        @foreach ($properties as $property)
                            <lable class="col-sm-2">
                                <input  type="checkbox" name="properties[]" value="{{ $property->id }}">{{ $property->title }}
                            </lable>
                        @endforeach
                    </div>
                </div>



                <div class="form-group">
                    <label for="title">عنوان</label>
                    <input type="text" class="form-control" name="title" id="title" >
                </div>

                <div class="form-group">
                    <label for="slug">اسلاگ</label>
                    <input type="text" class="form-control" name="slug" id="slug" >
                </div>


                <div class="form-group">
                    <input type="submit" name="submit" id="submit" value="ثبت" class="btn btn-primary">
                </div>

            </form>

        </div>
        @include('admin.layout.errors')
        @include('admin.layout.notification')
@endsection
@extends('admin.layout.master')


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ویرایش گروه مشخصات {{ $propertyGroup->title }} </h3>
                </div>

                <div class="card-body">

                    {{-- نمایش فرم ایجاد برای انتخاب دسته بندی والد --}}
                    <form action="{{ route('admin.property_groups.update', $propertyGroup) }}" method="post">
                        @csrf
                        @method('PATCH')
                        

                        <div class="form-group">
                           <label for="name">عنوان</label>
                           <input type="text" class="form-control" name="title" id="title" value="{{ $propertyGroup->title }}">
                        </div>

                     


                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" value="ثبت" class="btn btn-primary">
                        </div>
                        
                    </form>

                    {{-- نمایش ارور --}}
                    @include('admin.layout.errors')


                </div>
            </div>
        </div>
    </div>

@endsection
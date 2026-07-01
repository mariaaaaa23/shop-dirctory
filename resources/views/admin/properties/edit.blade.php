@extends('admin.layout.master')


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">ویرایش مشخصات {{ $property->title }}</h2>
                </div>

                <div class="card-body">

                    {{-- enctype="multipart/form-data"  یعنی فرمی که چند بخشی هست  برای اینکه فایلی رو آپلود کنیم بفرستیم سمت سرور--}}
                    <form action="{{ route('admin.properties.update', $property) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')


                           {{--  وقتی میخواییم محصول ایجاد کنیم باید دسته بندی اش را انتخاب کنیم --}}
                           <div class="form-grpup">
                            <label for="category_id">گروه ویژگی </label>
                            <select name="property_group_id" id="property_group_id" class="form-control">
                                <option value="" disabled selected>گروه ویژگی را انتخاب کنید</option>

                                @foreach ($groups as $group )
                                <option
                                {{-- نمایش کتگوری از قبل انتخاب شده --}}
                                @if ($group->id == $property->property_group_id)
                                    selected
                                @endif
                                value="{{ $group->id }}">{{ $group->title }}</option>
                                    
                                @endforeach
                            </select>
                        </div>


                       




                        <div class="form-group">
                           <label for="name">عنوان</label>
                           <input type="text" class="form-control" name="title" id="title" value="{{ $property->title }}">
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
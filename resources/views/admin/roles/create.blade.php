@extends('admin.layout.master')


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ایجاد نقش </h3>
                </div>

                <div class="card-body">

                    {{-- نمایش فرم ایجاد برای انتخاب دسته بندی والد --}}
                    <form action="{{ route('admin.roles.store') }}" method="post">
                        @csrf
                        

                        <div class="form-group">
                           <label for="name">عنوان</label>
                           <input type="text" class="form-control" name="name" id="name">
                        </div>

                        {{-- چک باکس برای انتخاب پرمشن یا دسترسی ها --}}
                        <div class="form-group">
                            <label>انتخاب دسترسی ها</label>
                            <div class="row">
                                @foreach ($permissions as $permission)
                                    <lable class="col-sm-2">
                                        <input  type="checkbox" name="permissions[]" value="{{ $permission->name }}">{{ $permission->name }}
                                    </lable>
                                @endforeach
                            </div>
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
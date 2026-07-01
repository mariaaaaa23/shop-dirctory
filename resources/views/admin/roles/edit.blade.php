@extends('admin.layout.master')


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ویرایش {{ $role->name }} </h3>
                </div>

                <div class="card-body">

                   
                <form class="custom-form contact-form row" action="{{ route('admin.roles.update', $role->id )}}" method="post" role="form">

                    {{-- توکن امنیتی برای جلوگیری از هک --}}
                    @csrf
                    @method('PATCH')
                    <div class="col-lg-6 col-6">
                        <label for="contact-name" class="form-label">عنوان</label>

                        <input type="text" name="name" id="name" class="form-control" placeholder="name" value="{{ $role->name }}" >
                    </div>

                    
                    {{-- برای نمایش دسترسی ها یا همان پرمشن ها --}}
                    <div class="form-group">
                        @foreach ($permissions as $permission )
                        {{--  name="permissions[]  وقتی میخواهیم یک رابطه چند به چند میخواییم پاس بدیم
                        و چندین رکورد اضافه بشه به یک رول خاص باید از آرایه استفاده کنیم واسه پاس دادن مقادیر چون مجموعه ای از پرمشن ها قراره نمایش بده--}}
                        {{-- و مقادیر یا همون value باید آیدی پرمشن باشد برای مثال {{ $permission->id }} --}}
                        <label class="m-2">
                            <input 

                            {{-- وقتی میخواهیم رولی را ویرایش کنیم روی دکمه ادیت کلیک میکنیم باید پرمشن ها یا همان دسترسی هایی که از قبل انتخاب شده برای ما نمایش داد با دستور @if --}}
                           
                            {{-- برای هر permission (دسترسی)
                         بررسی کن که آیا این role (نقش) این دسترسی را دارد یا خیر
                           اگر داشت → کلمه checked را داخل input قرار بده
                          اگر نداشت → چیزی قرار نده --}}
                            @if ($role->hasPermissionTo($permission))
                              checked  
                            @endif

                            type="checkbox" name="permissions[]" value="{{ $permission->name }}">{{ $permission->name }}</label>    
                        @endforeach
                    </div>


                    <div class="col-lg-5 col-12 ms-auto">
                        <button type="submit" class="form-control">submit</button>
                    </div>
                </form>

                </div>
            </div>

            @include('admin.layout.errors')

        </div>
    </div>

@endsection
@extends('admin.layout.master')


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">ایجاد اسلاید</h2>
                </div>

                <div class="card-body">

                    {{-- enctype="multipart/form-data"  یعنی فرمی که چند بخشی هست  برای اینکه فایلی رو آپلود کنیم بفرستیم سمت سرور--}}
                    <form action="{{ route('admin.sliders.store') }}" method="post" enctype="multipart/form-data">
                        @csrf


                        <div class="form-group">
                           <label for="links">لینک</label>
                           <input type="text" class="form-control" name="links" id="links">
                        </div>

                        {{-- فرم برای آپلود تصویر --}}
                        <div class="form-group">
                            <label for="image">تصویر</label>
                            <input type="file" name="image" id="image" class="from-control">
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
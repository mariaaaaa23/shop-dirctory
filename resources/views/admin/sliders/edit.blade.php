@extends('admin.layout.master')


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">ویرایش اسلاید</h2>
                </div>

                <div class="card-body">

                    {{-- enctype="multipart/form-data"  یعنی فرمی که چند بخشی هست  برای اینکه فایلی رو آپلود کنیم بفرستیم سمت سرور--}}
                    <form action="{{ route('admin.sliders.update', $slider) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')


                        <div class="form-group">
                            <label for="links">لینک</label>
                            <input type="text" class="form-control" name="links" id="links" value="{{ $slider->links }}">
                         </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="image">تصویر</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>
                                {{-- نمایش تصویر --}}
                                <div class="col-sm-6">
                                    <img src="{{ asset('storage/' . $slider->image) }}" width="100" alt="">
                                </div>
                            </div>
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
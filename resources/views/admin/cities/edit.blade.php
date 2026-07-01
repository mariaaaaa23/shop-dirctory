@extends('admin.layout.master')

@section('content')

<section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"> ویرایش شهر  </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            <form action="{{ route('admin.cities.update', $city) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="state_id">استان </label>
                    <select name="state_id" id="state_id" class="form-controller">
                        <option value="" disabled selected>استان را انتخاب کنید...</option>
                        @foreach ($states as $state )
                            <option
                            {{-- اگه دسته ای که انتخاب کردیم والد داشت بهمون نشون میده --}}
                            @if ($state->id == $city->state_id)
                                selected
                            @endif
                             value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">عنوان</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $city->name }}" >
                </div>

                


                <div class="form-group">
                    <label for="slug">اسلاگ</label>
                    <input type="text" class="form-control" name="slug" id="slug" value="{{ $city->slug }}" >
                </div>


                <div class="form-group">
                    <input type="submit" name="submit" id="submit" value="ثبت" class="btn btn-primary">
                </div>

            </form>

        </div>
        @include('admin.layout.errors')
        @include('admin.layout.notification')
@endsection
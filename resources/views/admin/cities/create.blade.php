@extends('admin.layout.master')

@section('content')

<section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"> ایجاد شهر   </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            <form action="{{ route('admin.cities.store') }}" method="post">
                @csrf
                
                <div class="form-group">
                    <label for="state_id">استان </label>
                    <select name="state_id" id="state_id" class="form-controller">
                        <option value="" disabled selected>استان را انتخاب کنید...</option>
                        @foreach ($states as $state )
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">عنوان</label>
                    <input type="text" class="form-control" name="name" id="name" >
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
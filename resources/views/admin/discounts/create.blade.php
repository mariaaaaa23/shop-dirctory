@extends('admin.layout.master')

@section('content')

<section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"> ایجاد تخفیف   </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            <form action="{{ route('admin.products.discounts.store', $product) }}" method="post">
                @csrf
                
                

                <div class="form-group">
                    <label for="name">مقدار</label>
                    <input type="number" max="100" min="1" class="form-control" name="value" id="value" >
                </div>

                



                <div class="form-group">
                    <input type="submit" name="submit" id="submit" value="ثبت" class="btn btn-primary">
                </div>

            </form>

        </div>
        @include('admin.layout.errors')
        @include('admin.layout.notification')
@endsection
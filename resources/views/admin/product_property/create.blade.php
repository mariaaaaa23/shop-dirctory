@extends('admin.layout.master')

@section('content')

<section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"> ویژگی های محصول {{ $product->name }}  </h3>
          </div>

          @php
             $propertyGroups = $product->category?->propertyGroups;
          @endphp

          <!-- /.card-header -->
          <div class="card-body">

            <form action="{{ route('admin.product_property.store', ['product' => $product->id]) }}" method="post">
                @csrf
                
                {{-- نمایش نام گروه مشخصات --}}
                        @foreach ($propertyGroups as $group )
                            <h3>{{ $group->title }}</h3>

                            <div class="row">
                                {{-- برای هر کدوم از این ویژگی ها بیا و یک تکست باکس قرار بده که داخلش اسم ویژگی باشه--}}
                                @foreach ($group->properties as $property)
                                <div class="form-group col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label for="name">{{ $property->title }}</label>
                                           </div>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="properties[{{ $property->id }}][value]" id="title" value="{{ $property->getValueForProduct($product) }}">
                                        </div>
                                     </div>
                                </div>
                        @endforeach
                        </div>
                    @endforeach
                    
                        

              

                <div class="form-group">
                    <input type="submit" name="submit" id="submit" value="ثبت" class="btn btn-primary">
                </div>

            </form>

        </div>
        @include('admin.layout.errors')
        @include('admin.layout.notification')
@endsection
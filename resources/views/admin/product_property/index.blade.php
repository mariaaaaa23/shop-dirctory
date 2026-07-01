@extends('admin.layout.master')


@section('content')

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">ویژگی های محصول {{$product->name}} </h2>
                    <a class="btn btn-success btn-sm" href="{{ route('admin.product_property.create', $product)}}">تغییر مقادیر ویژگی ها</a>
                </div>
                

                        <div class="card-body">
               
                            <table id="example2" class="table table-bordered table-hover text-center">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>نام</th>
                                        <th>مقدار</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
            
                                    @foreach ($product->properties as $property)
                                    <tr>
                                      <td>{{ $property->id }}</td>
                                      <td>{{ $property->title }}</td>
                                      {{-- برای نمایش مقدار --}}
                                      <td>{{ $property->pivot->value }}</td>
                                      
                                    </tr>
                                    
                                @endforeach
                                </tbody>
            
            
                                 
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>نام</th>
                                    
                                </tr>
                                </tfoot>
                              </table>
                            </div>
            </div>

            {{-- نمایش ارور --}}
            @if (count($errors->all()) > 0)
              <ul class="bg-danger">
                @foreach ($errors->all() as $error )
                    <li class="text-white">{{ $error }}</li>
                @endforeach 
            </ul>  
            @endif

        </div>
    </div>

@endsection
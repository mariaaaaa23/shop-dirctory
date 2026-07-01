@extends('admin.layout.master')

@section('content')

   <div class="row">
       <div class="col-sm-12">
          <div class="card">
            
            <div class="card-header">
                <h2 class="card.title">
                     محصولات
                </h2>
            </div>

            <div class="card-body">
               
                <table id="example2" class="table table-bordered table-hover text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>قیمت</th>
                            <th>دسته بندی</th>
                            <th>برند</th>
                            <th>تصویر</th>
                            <th>گالری</th>
                            <th>ویژگی ها</th>
                            <th>ویژگی ها</th>
                            <th>کامنت ها</th>
                            <th>تخفیف</th>
                            <th>تاریخ ایجاد</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($products as $product)
                        <tr>
                          <td>{{ $product->id }}</td>
                          <td>{{ $product->name }}</td>
                          <td>{{ $product->cost }}</td>
                          <td>{{ $product->category->title }}</td>
                          <td>{{ $product->brand->name }}</td>
                          <td>
                            <img src="{{ asset('storage/' . $product->image) }}" width="100" alt="">
                          </td>
                          <td>
                            <a href="{{ route('admin.products.pictures.index', $product) }}" class="btn btn-sm btn-warning">گالری</a>
                          </td>
                          
                            
                          <td>
                            <a href="{{ route('admin.product_property.index', $product) }}" class="btn btn-sm btn-warning">ویژگی ها</a>
                          </td>

                          <td>
                            <a href="{{ route('admin.products.variations.index', ['product' => $product->id]) }}" class="btn btn-sm btn-warning">تنوع‌ها</a>
                          </td>

                            
                          <td>
                            <a href="{{ route('admin.product.comments.index', $product) }}" class="btn btn-sm btn-warning">کامنت ها</a>
                          </td>
                                
                          <td>
                            @if($product->discount)
                            <p>{{ $product->discount->value }}%</p>
                    
                            <form action="{{ route('admin.products.discounts.destroy', ['product'=>$product , 'discount'=>$product->discount]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="btn btn-sm btn-danger" value="حذف">
                            </form>
                        @else
                            <a href="{{ route('admin.products.discounts.create', $product) }}" class="btn btn-sm btn-success">
                                ایجاد تخفیف
                            </a>
                        @endif
                          </td>
                            
                          <td>
                          </td>

                          <td>
                            <a href="{{ route('admin.products.edit',$product) }}" class="btn btn-sm btn-primary">ویرایش</a>
                          </td>
                          <td>
                            <form action="{{ route('admin.products.destroy',$product) }}" method="post">
                              @csrf
                              @method('DELETE')
                              <input type="submit" class="btn btn-sm btn-danger" value="حذف">
                            </form>
                          </td>
                        </tr>
                        
                    @endforeach
                    </tbody>


                     
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>قیمت</th>
                        <th>دسته بندی</th>
                        <th>برند</th>
                        <th>نصویر</th>
                        <th>گالری</th>
                        <th>ویژگی ها</th>
                        <th>کامنت ها</th>
                        <th>تخفیف</th>
                        <th>تاریخ ایجاد</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
    
       </div>
   </div>

@endsection

@section('scripts')

   <!-- DataTables -->
<script src="/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="/admin/plugins/datatables/dataTables.bootstrap4.js"></script>

@endsection
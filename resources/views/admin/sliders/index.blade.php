@extends('admin.layout.master')

@section('content')

   <div class="row">
       <div class="col-sm-12">
          <div class="card">

            <div class="card-header">
                <h2 class="card.title">
                    اسلایدر
                </h2>
            </div>

            <div class="card-body">
               
                <table id="example2" class="table table-bordered table-hover text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>تصویر</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($sliders as $slider)
                        <tr>
                          <td>{{ $slider->id }}</td>
                          
                          <td>
                            <a href="{{ $slider->links }}" target="_blank">{{ $slider->links }}</a>
                        </td>
                        <td>
                            <img src="{{ asset('storage/' . $slider->image) }}" width="100" alt="اسلایدر">
                        </td>
                         
                          <td>
                            <a href="{{ route('admin.sliders.edit',$slider) }}" class="btn btn-sm btn-primary">ویرایش</a>
                          </td>
                          <td>
                            <form action="{{ route('admin.sliders.destroy',$slider) }}" method="post">
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
@extends('admin.layout.master')

@section('content')

   <div class="row">
       <div class="col-sm-12">
          <div class="card">
            
            <div class="card-header">
                <h2 class="card.title">
                    نقش ها
                </h2>
            </div>

            <div class="card-body">
               
                <table id="example2" class="table table-bordered table-hover text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>عنوان</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($roles as $role)
                        <tr>
                          <td>{{ $role->id }}</td>
                          <td>{{ $role->name }}</td>
                          
                          <td>
                            <a href="{{ route('admin.roles.edit',$role) }}" class="btn btn-sm btn-primary">ویرایش</a>
                          </td>
                          <td>
                            <form action="{{ route('admin.roles.destroy',$role) }}" method="post">
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
                        <th>عنوان</th>
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
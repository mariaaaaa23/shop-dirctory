@extends('admin.layout.master')

@section('content')


<section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"> مشخصات </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>#</th>
                <th>عنوان</th>
                <th>گروه مشخصات</th>
                <th>ویرایش</th>
                <th>حذف</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($properties as $property )
                <tr>
                    <td>{{ $property->id }}</td>
                    <td>{{ $property->title }}</td>
                    <td>{{ optional($property->propertyGroup)->title }}</td>
                    <td>
                        <a href="{{ route('admin.properties.edit',$property) }}" class="btn btn-sm btn-primary">ویرایش</a>
                    </td>
                    <td>
                        <form action="{{ route('admin.properties.destroy', $property) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="btn btn-danger btn-sm" value="حذف">
                        </form>
                    </td>
                  </tr> 
                @endforeach
              

               


              </tbody>
              <tfoot>
              <tr>
                <th>#</th>
                <th>عنوان</th>
                <th>گروه مشخصات</th>
                <th>ویرایش</th>
                <th>حذف</th>
              </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>

@endsection
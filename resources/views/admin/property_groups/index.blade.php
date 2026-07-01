@extends('admin.layout.master')

@section('content')


<section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"> گروه مشخصات </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>#</th>
                <th>عنوان</th>
                <th>ویرایش</th>
                <th>حذف</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($propertyGroups as $propertyGroup )
                <tr>
                    <td>{{ $propertyGroup->id }}</td>
                    <td>{{ $propertyGroup->title }}</td>
                    <td>
                        <a href="{{ route('admin.property_groups.edit',$propertyGroup) }}" class="btn btn-sm btn-primary">ویرایش</a>
                    </td>
                    <td>
                        <form action="{{ route('admin.property_groups.destroy', $propertyGroup) }}" method="post">
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
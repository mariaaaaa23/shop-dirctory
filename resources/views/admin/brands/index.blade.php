@extends('admin.layout.master')

@section('content')


<section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"> برند  ها </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>#</th>
                <th>نام</th>
                <th>اسلاگ</th>
                <th>تصویر</th>
                <th>ویرایش</th>
                <th>حذف</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($brands as $brand )
                <tr>
                    <td>{{ $brand->id }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->slug }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $brand->image) }}" width="100" alt="">
                    </td>
                    <td>
                        <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-sm btn-primary">ویرایش</a>
                    </td>
                    <td>
                        <form action="{{ route('admin.brands.destroy', $brand) }}" method="post">
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
                <th>نام</th>
                <th>اسلاگ</th>
                <th>تصویر</th>
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
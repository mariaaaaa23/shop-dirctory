@extends('admin.layout.master')

@section('content')


<section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"> دسته بندی ها </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>#</th>
                <th>عنوان</th>
                <th>اسلاگ</th>
                <th>دسته والد</th>
                <th>ویرایش</th>
                <th>حذف</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($categories as $category )
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->title }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>{{ optional($category->parent)->title }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit',$category) }}" class="btn btn-sm btn-primary">ویرایش</a>
                    </td>
                    <td>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="post">
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
                <th>اسلاگ</th>
                <th>دسته والد</th>
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
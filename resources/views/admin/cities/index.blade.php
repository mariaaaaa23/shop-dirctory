@extends('admin.layout.master')

@section('content')


<section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"> شهر  ها </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>#</th>
                <th>عنوان</th>
                <th>استان</th>
                <th>اسلاگ</th>
                <th>ویرایش</th>
                <th>حذف</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($cities as $city )
                <tr>
                    <td>{{ $city->id }}</td>
                    <td>{{ $city->name }}</td>
                    <td>{{ $city->state->name}}</td>
                    <td>{{ $city->slug }}</td>
                    <td>
                        <a href="{{ route('admin.cities.edit',$city) }}" class="btn btn-sm btn-primary">ویرایش</a>
                    </td>
                    <td>
                        <form action="{{ route('admin.cities.destroy', $city) }}" method="post">
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
                <th>استان</th>
                <th>اسلاگ</th>
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
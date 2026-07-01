@extends('admin.layout.master')

@section('content')

   <div class="row">
       <div class="col-sm-12">
          <div class="card">

            <div class="card-header">
                <h2 class="card.title">
                    کامنت های محصول {{ $product->name }}
                </h2>
            </div>

            <div class="card-body">
               
                <table id="example2" class="table table-bordered table-hover text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>نام کاربر</th>
                            <th>کامنت کاربر</th>
                            <th>حذف</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($comments as $comment)
                        <tr>
                          <td>{{ $comment->id }}</td>
                          <td>{{ $comment->user->name }}</td>
                          <td>{{ $comment->text }}</td>
                          <td>
                            <form action="{{ route('admin.comments.destroy',$comment) }}" method="post">
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
                        <th>نام کاربر</th>
                        <th>کامنت کاربر</th>
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



@endsection
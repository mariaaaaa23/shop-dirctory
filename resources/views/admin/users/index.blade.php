@extends('admin.layout.master')

@section('content')

   <div class="row">
       <div class="col-sm-12">
          <div class="card">

            <div class="card-header">
                <h2 class="card.title">
                    کاربران
                </h2>
            </div>

            <div class="card-body">
               
                <table id="example2" class="table table-bordered table-hover text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>موبایل</th>
                            <th>نقش</th>
                            <th>وضعیت</th>
                            <th>درخواست پنل نویسندگی</th>
                            <th>ویرایش</th>
                            <th>حذف</th>
                            
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $user)
                        <tr>
                          <td>{{ $user->id }}</td>
                          <td>{{ $user->name }}</td>
                          <td>{{ $user->phone }}</td>
                          <td>{{ $user->getRoleNames()->join(' , ') }}</td>

                          <td>
                            {{-- فرم تغییر آنی نقش توسط ادمین --}}
                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                
                                <select name="role" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                                    {{-- گزینه کاربر عادی --}}
                                    <option value="none" {{ !$user->roles->pluck('name')->first() ? 'selected' : '' }}>
                                        کاربر عادی (بدون نقش)
                                    </option>
                                    
                                    {{-- گزینه نویسنده --}}
                                    <option value="author" {{ $user->roles->pluck('name')->first() == 'author' ? 'selected' : '' }}>
                                        author (نویسنده)
                                    </option>
                                    
                                    {{-- گزینه ادمین --}}
                                    <option value="admin" {{ $user->roles->pluck('name')->first() == 'admin' ? 'selected' : '' }}>
                                        admin (مدیر)
                                    </option>
                                </select>
                            </form>
                        </td>

                        <td>
                          @if($user->roles->pluck('name')->first() == 'admin')
                              <span class="badge bg-danger">مدیر سایت</span>
                          @elseif($user->roles->pluck('name')->first() == 'author')
                              <span class="badge bg-success">نویسنده (تایید شده)</span>
                          @elseif($user->status == 'pending')
                              {{-- ⏱️ نمایش سیگنال درخواست جدید به ادمین --}}
                              <span class="badge bg-warning text-dark animate-pulse"> درخواست پنل نویسندگی</span>
                          @else
                              <span class="badge bg-secondary">کاربر عادی</span>
                          @endif
                      </td>
                          
                          <td>
                            <a href="{{ route('admin.users.edit',$user) }}" class="btn btn-sm btn-primary">ویرایش</a>
                          </td>
                          <td>
                            <form action="{{ route('admin.users.destroy',$user) }}" method="post">
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
                        <th>موبایل</th>
                        <th>نقش</th>
                        <th>وضعیت</th>
                        <th>درخواست پنل نویسندگی</th>
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



@endsection
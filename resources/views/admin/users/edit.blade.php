@extends('admin.layout.master')


@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ویرایش نقش {{ $user->name }} </h3>
                </div>

                <div class="card-body">

                   
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                    
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>نام کاربر:</label>
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control" readonly>
                            </div>
                    
                            <div class="col-md-6 mb-3">
                                <label>موبایل:</label>
                                <input type="email" value="{{ $user->phone }}" class="form-control" disabled>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-danger">تغییر نقش کاربری:</label>
                                <select name="role" class="form-control">
                                    <option value="">بدون نقش (کاربر عادی)</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ $userRole == $role->name ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    
                        <button type="submit" class="btn btn-primary mt-3">بروزرسانی اطلاعات کاربر</button>
                    </form>

                </div>
            </div>

            @include('admin.layout.errors')

        </div>
    </div>

@endsection
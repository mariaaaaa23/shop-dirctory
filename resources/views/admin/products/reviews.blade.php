@extends('admin.layout.master')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">بررسی آگهی‌های نویسندگان (در انتظار تایید)</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>نام آگهی</th>
                    <th>نویسنده</th>
                    <th>قیمت</th>
                    <th>عملیات بررسی</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->user->name ?? 'کاربر' }}</td>
                        <td>{{ number_format($product->cost) }} تومان</td>
                        <td>
                            <!-- دکمه تایید فوری -->
                            <form action="{{ route('admin.products.changeStatus', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="btn btn-success btn-sm"> تایید و انتشار</button>
                            </form>

                            <!-- دکمه رد فوری -->
                            <form action="{{ route('admin.products.changeStatus', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn btn-danger btn-sm"> رد آگهی</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">هیچ آگهی در انتظار تاییدی وجود ندارد.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
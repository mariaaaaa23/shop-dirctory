@extends('client.layout.master')

@section('content')

<div class="container my-5" dir="rtl">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2 class="fw-bold">لیست علاقه‌مندی‌های من</h2>
            <p class="text-muted">محصولاتی که به آن‌ها علاقه دارید را در این صفحه مدیریت کنید.</p>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="py-3">تصویر محصول</th>
                            <th scope="col" class="py-3">نام محصول</th>
                            <th scope="col" class="py-3">قیمت</th>
                            <th scope="col" class="py-3">حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                   @foreach ($products as $product)
                   
                    <tr id="wishlist-row-1">
                        <td class="align-middle py-3">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-width: 80px;">
                        </td>
                        <td class="align-middle py-3">
                            <h6 class="mb-0 fw-bold">{{ $product->name }}</h6>
                            <small class="text-muted">{{ $product->category->title }}</small>
                        </td>
                        <td class="align-middle py-3 fw-bold text-dark">
                            {{ $product->cost }} تومان
                        </td>
                        
                        <td class="align-middle py-3">
                    
                                            <form action="{{ route('client.likes.destroy', $product->id) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle p-2" title="حذف">
                                                    <iconify-icon icon="fluent:delete-24-filled" class="fs-5 d-block"></iconify-icon>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                </button>
                            </div>
                        </td>
                    </tr>
                   @endforeach
                   </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
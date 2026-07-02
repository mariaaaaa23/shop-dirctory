@extends('client.layout.master') {{-- یا هر لایه‌اوت اصلی که در پروژه‌ات داری --}}

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="fw-bold">{{ $title }}</h2>
            <hr class="w-25 mx-auto" dir="rtl">
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-4 g-4" dir="rtl">
        @forelse ($products as $product)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->title }}" style="height: 200px; object-fit: contain;">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $product->title }}</h5>
                        <div class="price-box mt-2">
                            @if($product->has_discount)
                              {{-- قیمت اصلی (قدیم) که خط می‌خورد --}}
                              <span class="text-muted small text-decoration-line-through me-2" style="text-decoration: line-through; font-size: 0.9rem;">
                                {{ number_format($product->cost) }}
                              </span>
                
                              {{-- قیمت نهایی و تخفیف‌خورده --}}
                              <h3 class="secondary-font text-danger d-inline-block m-0">
                                {{ number_format($product->with_discount) }} <span style="font-size: 0.8rem;">تومان</span>
                              </h3>
                            @else
                              {{-- قیمت معمولی بدون تخفیف --}}
                              <h3 class="secondary-font text-primary m-0">
                                {{ number_format($product->cost) }} <span style="font-size: 0.8rem;">تومان</span>
                              </h3>
                            @endif
                          </div>
                        <a href="{{ route('client.products.show', $product->id) }}" class="btn btn-primary btn-sm">مشاهده محصول</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center my-5" dir="rtl">
                <p class="text-muted h5">هنوز هیچ محصولی برای این برند ثبت نشده است.</p>
            </div>
        @endforelse
    </div>

    {{-- بخش صفحه‌بندی --}}
    <div class="d-flex justify-content-center mt-5">
        {{ $products->links() }}
    </div>
</div>
@endsection
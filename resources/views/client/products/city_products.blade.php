@extends('client.layout.master')
 @section('content')
<div class="container my-5" dir="rtl">
    <div class="mb-4 border-bottom pb-2">
        <h2 class="fw-bold text-dark"> آگهی‌ها و محصولات شهر {{ $city->name }}</h2>
        <p class="text-muted small">نمایش آگهی‌های فعال در محدوده {{ $city->name }}</p>
    </div>

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
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
      
                    <div class="card-footer bg-white border-0 text-center">
                        <a href="{{ route('client.products.show', $product->id) }}" class="btn btn-sm btn-outline-primary w-100">مشاهده آگهی</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="text-muted mb-3"> متاسفانه هنوز هیچ آگهی یا محصولی برای شهر <strong>{{ $city->name }}</strong> ثبت نشده است.</div>
                <a href="/" class="btn btn-sm btn-primary">بازگشت به صفحه اصلی</a>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
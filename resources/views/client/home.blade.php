@extends('client.layout.master')

<style>
  /* ایجاد فاصله برای اینکه فلش‌ها روی محصولات نیفتند */
.container-slider {
    padding: 0 50px; /* ۵۰ پیکسل از چپ و راست فاصله بده */
    position: relative;
}

/* تنظیم دقیق فلش‌ها در حالت راست‌چین (RTL) */
.swiper-button-next, 
.swiper-button-prev {
    color: #333; /* رنگ فلش‌ها */
    background-color: rgba(255, 255, 255, 0.8); /* یک پس‌زمینه نیمه‌شفاف سفید */
    padding: 20px;
    border-radius: 50%; /* گرد کردن پس‌زمینه فلش‌ها */
    width: 40px;
    height: 40px;
}

/* برای اینکه توی موبایل خیلی بزرگ نشن */
@media (max-width: 768px) {
    .swiper-button-next, .swiper-button-prev {
        display: none; /* توی موبایل فلش‌ها رو مخفی کن چون لمسی هست */
    }
}
</style>

@section('content')

<section id="banner" style="background: #F9F3EC;">
  <div class="container">
    <div class="swiper main-swiper">
      <div class="swiper-wrapper">

        
        @foreach ($sliders as $slider)
        <div class="swiper-slide py-5">
          <div class="row banner-content align-items-center">
            <div class="img-wrapper col-md-5">
              <img src="{{ asset('storage/' .$slider->image) }}" class="img-fluid">
            </div>
            <div class="content-wrapper col-md-7 p-5 mb-5" dir="rtl">
              <div class="secondary-font text-primary text-uppercase mb-4">10-20% تخفیف ویژه</div>
              <h2 class="banner-title display-1 fw-normal">بهترین رفیق برای <span class="text-primary">حیوان خانگی تو
                  </span>
              </h2>
              <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">
                همین حالا خرید کن 
                <svg width="24" height="24" viewBox="0 0 24 24" class="mb-1">
                  <use xlink:href="/client/#arrow-right"></use>
                </svg></a>
            </div>
          </div>
        </div>
        @endforeach

      <div class="swiper-pagination mb-5"></div>

    </div>
  </div>
</section>

<section id="categories">
  <div class="container my-3 py-5">
    <div class="row my-5">
      @foreach ($brands as $brand )
      <div class="col text-center">
        <a href="{{ route('client.shop.filter', ['type' => 'brand', 'id' => $brand->id]) }}" class="categories-item">
          <div class="item"><a href="{{ route('client.shop.filter', ['type' => 'brand', 'id' => $brand->id]) }}"><img src="{{asset('storage/' . $brand->image)  }}" alt="{{ $brand->name }}" style="height: 200px; width: 200px; width: 100%;" ></a> </div>
          <h5>{{ $brand->name }}</h5>
        </a>
      </div>
      @endforeach
      
    </div>
  </div>
</section>

<section id="clothing" class="my-5 overflow-hidden">
  <div class="container pb-5" dir="rtl">

    <div class="section-header d-md-flex justify-content-between align-items-center mb-3">
      <h2 class="display-3 fw-normal">لباس</h2>
      <div>
        <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">
          shop now
          <svg width="24" height="24" viewBox="0 0 24 24" class="mb-1">
            <use xlink:href="/client/#arrow-right"></use>
          </svg>
        </a>
      </div>
    </div>

    <div class="products-carousel swiper">
      <div class="swiper-wrapper">
        
        @foreach ($featuredCategoryProducts as $product)
        
        {{--  شرط فیلتر وضعیت: فقط آگهی‌های تایید شده رندر شوند --}}
        @if($product->status == 'approved')
        
        <div class="swiper-slide">
          
          <div class="card position-relative">
            
            {{-- نمایش درصد تخفیف روی عکس محصول --}}
          @if ($product->has_discount)
          <div class="z-1 position-absolute rounded-3 m-3 bg-danger text-black font-weight-bold" style="direction: ltr;">
            {{ $product->discount_value }}% OFF
          </div>
        @endif

        <a href="{{ route('client.products.show', $product->id) }}"><img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-4" alt="{{ $product->name }}" style="height: 250px; width: 250px; width: 100%;"></a>
            
            <div class="card-body p-0">
              <a href="/client/single-product.html">
                <h3 class="card-title pt-4 m-0">{{ $product->name }}</h3>
              </a>

              <div class="card-text">
                <span class="rating secondary-font">
                  <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                  <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                  <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                  <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                  <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                  5.0
                </span>

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

                <div class="d-flex flex-wrap mt-3">
                  <a href="#" class="btn-cart me-3 px-4 pt-3 pb-3 add-to-cart-btn" data-id="{{ $product->id }}">
                  <h5 class="text-uppercase m-0">افزودن به سبد خرید</h5>
                  </a>
                  <a href="#" class="btn-wishlist px-4 pt-3 ">
                    <iconify-icon  id="like-{{ $product->id }}" 
                      class="fa fa-heart @if($product->is_liked) like @endif" 
                      onclick="like({{ $product->id }})"icon="fluent:heart-28-filled" class="fs-5"> </iconify-icon>
                  </a>
                </div>
              </div>

            </div>
          </div> 
        </div>
        
        @endif 
        @endforeach
        
      </div> 
    </div>
  </div>
</section>

<section id="foodies" class="my-5">
  <div class="container my-5 py-5" dir="rtl">

    <div class="section-header d-md-flex justify-content-between align-items-center">
      <h2 class="display-3 fw-normal">{{ $category->title }}</h2>
      <div class="mb-4 mb-md-0">
        
      </div>
      <div>
        <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">
          shop now
          <svg width="24" height="24" viewBox="0 0 24 24" class="mb-1">
            <use xlink:href="/client/#arrow-right"></use>
          </svg></a>
      </div>
    </div>

    {{-- یک پوشش اصلی برای بخش اسلایدر همراه با دکمه‌های کنترل ایجاد می‌کنیم --}}
<div class="position-relative container-slider">
    
  <!-- ساختار اصلی اسلایدر سوایپر -->
  <div class="swiper category-products-swiper" dir="rtl">
      <div class="swiper-wrapper">

          @foreach ($category->getAllSubCategoryProducts() as $product)
              {{-- شرط حیاتی: فقط اگر وضعیت آگهی تایید شده (approved) بود، کارت محصول را رندر کن --}}
              @if($product->status == 'approved')
              
              <div class="swiper-slide my-4">
                  <div class="card position-relative">

                      {{-- نمایش درصد تخفیف روی عکس محصول --}}
                      @if ($product->has_discount)
                          <div class="z-1 position-absolute rounded-3 m-3 bg-danger text-black font-weight-bold" style="direction: ltr;">
                              {{ $product->discount_value }}% OFF
                          </div>
                      @endif

                      <a href="{{ route('client.products.show', $product->id) }}">
                          <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-4" alt="{{ $product->name }}" style="height: 250px; width: 100%; object-fit: cover;">
                      </a>
                      
                      <div class="card-body p-0">
                          <a href="/client/single-product.html">
                              <h3 class="card-title pt-4 m-0">{{ $product->name }}</h3>
                          </a>

                          <div class="card-text">
                              <span class="rating secondary-font">
                                  <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                                  <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                                  <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                                  <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                                  <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                                  5.0
                              </span>

                              <div class="price-box mt-2">
                                  @if($product->has_discount)
                                      <span class="text-muted small text-decoration-line-through me-2" style="text-decoration: line-through; font-size: 0.9rem;">
                                          {{ number_format($product->cost) }}
                                      </span>
                                      <h3 class="secondary-font text-danger d-inline-block m-0">
                                          {{ number_format($product->with_discount) }} <span style="font-size: 0.8rem;">تومان</span>
                                      </h3>
                                  @else
                                      <h3 class="secondary-font text-primary m-0">
                                          {{ number_format($product->cost) }} <span style="font-size: 0.8rem;">تومان</span>
                                      </h3>
                                  @endif
                              </div>

                              <div class="d-flex flex-wrap mt-3">
                                  <a href="#" class="btn-cart me-3 px-4 pt-3 pb-3 add-to-cart-btn" data-id="{{ $product->id }}">
                                      <h5 class="text-uppercase m-0">افزودن به سبد خرید</h5>
                                  </a>
                                  <a href="#" class="btn-wishlist px-4 pt-3 ">
                                      <iconify-icon id="like-{{ $product->id }}" 
                                          class="fa fa-heart @if($product->is_liked) like @endif" 
                                          onclick="like({{ $product->id }})" icon="fluent:heart-28-filled" class="fs-5">
                                        </iconify-icon>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                
                @endif 
            @endforeach

        </div>
    </div>

    <!-- 🎛️ دکمه‌های فلش چپ و راست برای حرکت دادن اسلایدر -->
    <div class="swiper-button-next category-next-btn"></div>
    <div class="swiper-button-prev category-prev-btn"></div>
</div>


  </div>
</section>

<section id="banner-2" class="my-3" style="background: #F9F3EC;">
  <div class="container">
    <div class="row flex-row-reverse banner-content align-items-center">
      <div class="img-wrapper col-12 col-md-6">
        <img src="/client/images/banner-img2.png" class="img-fluid">
      </div>
      <div class="content-wrapper col-12 offset-md-1 col-md-5 p-5">
        <div class="secondary-font text-primary text-uppercase mb-3 fs-4">تا 40% تخفیف بی سابقه</div>
        <h2 class="banner-title display-1 fw-normal">حراج بزرگ انبار تکانی
        </h2>
        <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">
          خرید سریع
          <svg width="24" height="24" viewBox="0 0 24 24" class="mb-1">
            <use xlink:href="/client/#arrow-right"></use>
          </svg></a>
      </div>

    </div>
  </div>
</section>

<section id="testimonial">
  <div class="container my-5 py-5">
    <div class="row">
      <div class="offset-md-1 col-md-10">
        <div class="swiper testimonial-swiper">
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="row ">
                <div class="col-2">
                  <iconify-icon icon="ri:double-quotes-l" class="quote-icon text-primary"></iconify-icon>
                </div>
                <div class="col-md-10 mt-md-5 p-5 pt-0 pt-md-5">
                  <p class="testimonial-content fs-2">At the core of our practice is the idea that cities are the
                    incubators of our
                    greatest achievements, and the best hope for a sustainable future.</p>
                  <p class="text-black">- Joshima Lin</p>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="row ">
                <div class="col-2">
                  <iconify-icon icon="ri:double-quotes-l" class="quote-icon text-primary"></iconify-icon>
                </div>
                <div class="col-md-10 mt-md-5 p-5 pt-0 pt-md-5">
                  <p class="testimonial-content fs-2">At the core of our practice is the idea that cities are the
                    incubators of our
                    greatest achievements, and the best hope for a sustainable future.</p>
                  <p class="text-black">- Joshima Lin</p>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="row ">
                <div class="col-2">
                  <iconify-icon icon="ri:double-quotes-l" class="quote-icon text-primary"></iconify-icon>
                </div>
                <div class="col-md-10 mt-md-5 p-5 pt-0 pt-md-5">
                  <p class="testimonial-content fs-2">At the core of our practice is the idea that cities are the
                    incubators of our
                    greatest achievements, and the best hope for a sustainable future.</p>
                  <p class="text-black">- Joshima Lin</p>
                </div>
              </div>
            </div>

          </div>

          <div class="swiper-pagination"></div>

        </div>
      </div>
    </div>
  </div>

</section>

<section id="bestselling" class="my-5 overflow-hidden">
  <div class="container py-5 mb-5">

    <div class="section-header d-md-flex justify-content-between align-items-center mb-3" dir="rtl">
      <h2 class="display-3 fw-normal">محصولات</h2>
      <div>
        <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">
          shop now
          <svg width="24" height="24" viewBox="0 0 24 24" class="mb-1">
            <use xlink:href="/client/#arrow-right"></use>
          </svg></a>
      </div>
    </div>

    <div class="swiper bestselling-swiper" dir="rtl">
      <div class="swiper-wrapper">

        @foreach ($products as $product )
        
        {{--  شرط فیلتر وضعیت: فقط آگهی‌های منتشر شده نمایش داده شوند --}}
        @if($product->status == 'approved')
        
        <div class="swiper-slide">
          <!-- <div class="z-1 position-absolute rounded-3 m-3 px-3 border border-dark-subtle">
            New
          </div> -->
          <div class="card position-relative">
            <a href="{{ route('client.products.show', $product->id) }}"><img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-4" alt="image"></a>
            <div class="card-body p-0">
              <a href="/client/single-product.html">
                <h3 class="card-title pt-4 m-0">{{ $product->name }}</h3>
              </a>

              <div class="card-text">
                <span class="rating secondary-font">
                  <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                  <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                  <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                  <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                  <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                  5.0</span>

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

                <div class="d-flex flex-wrap mt-3">
                  <a href="#" class="btn-cart me-3 px-4 pt-3 pb-3 add-to-cart-btn" data-id="{{ $product->id }}">
                    <h5 class="text-uppercase m-0">افزودن به سبد خرید</h5>
                    </a>
                  <a href="#" class="btn-wishlist px-4 pt-3 ">
                    <iconify-icon id="like-{{ $product->id }}" class="fa fa-heart @if ($product->is_liked) like @endif"
                      onclick="like({{ $product->id }})" icon="fluent:heart-28-filled" class="fs-5"></iconify-icon>
                  </a>
                </div>

              </div>

            </div>
          </div>
        </div>
        
        @endif 
        @endforeach

      </div>
    </div>
    <!-- / category-carousel -->


  </div>
</section>

<section id="register" style="background: url('images/background-img.png') no-repeat;">
  <div class="container ">
    <div class="row my-5 py-5">
      <div class="offset-md-3 col-md-6 my-5 ">
        <h2 class="display-3 fw-normal text-center">Get 20% Off on <span class="text-primary">first Purchase</span>
        </h2>
        <form>
          <div class="mb-3">
            <input type="email" class="form-control form-control-lg" name="email" id="email"
              placeholder="Enter Your Email Address">
          </div>
          <div class="mb-3">
            <input type="password" class="form-control form-control-lg" name="email" id="password1"
              placeholder="Create Password">
          </div>
          <div class="mb-3">
            <input type="password" class="form-control form-control-lg" name="email" id="password2"
              placeholder="Repeat Password">
          </div>

          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-dark btn-lg rounded-1">Register it now</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<section id="latest-blog" class="my-5">
  <div class="container py-5 my-5">
    <div class="row mt-5">
      <div class="section-header d-md-flex justify-content-between align-items-center mb-3">
        <h2 class="display-3 fw-normal">Latest Blog Post</h2>
        <div>
          <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">
            Read all
            <svg width="24" height="24" viewBox="0 0 24 24" class="mb-1">
              <use xlink:href="/client/#arrow-right"></use>
            </svg></a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 my-4 my-md-0">
        <div class="z-1 position-absolute rounded-3 m-2 px-3 pt-1 bg-light">
          <h3 class="secondary-font text-primary m-0">20</h3>
          <p class="secondary-font fs-6 m-0">Feb</p>

        </div>
        <div class="card position-relative">
          <a href="/client/single-post.html"><img src="/client/images/blog1.jpg" class="img-fluid rounded-4" alt="image"></a>
          <div class="card-body p-0">
            <a href="/client/single-post.html">
              <h3 class="card-title pt-4 pb-3 m-0">10 Reasons to be helpful towards any animals</h3>
            </a>

            <div class="card-text">
              <p class="blog-paragraph fs-6">At the core of our practice is the idea that cities are the incubators of
                our greatest
                achievements, and the best hope for a sustainable future.</p>
              <a href="/client/single-post.html" class="blog-read">read more</a>
            </div>

          </div>
        </div>
      </div>
      <div class="col-md-4 my-4 my-md-0">
        <div class="z-1 position-absolute rounded-3 m-2 px-3 pt-1 bg-light">
          <h3 class="secondary-font text-primary m-0">21</h3>
          <p class="secondary-font fs-6 m-0">Feb</p>

        </div>
        <div class="card position-relative">
          <a href="/client/single-post.html"><img src="/client/images/blog2.jpg" class="img-fluid rounded-4" alt="image"></a>
          <div class="card-body p-0">
            <a href="/client/single-post.html">
              <h3 class="card-title pt-4 pb-3 m-0">How to know your pet is hungry</h3>
            </a>

            <div class="card-text">
              <p class="blog-paragraph fs-6">At the core of our practice is the idea that cities are the incubators of
                our greatest
                achievements, and the best hope for a sustainable future.</p>
              <a href="/client/single-post.html" class="blog-read">read more</a>
            </div>

          </div>
        </div>
      </div>
      <div class="col-md-4 my-4 my-md-0">
        <div class="z-1 position-absolute rounded-3 m-2 px-3 pt-1 bg-light">
          <h3 class="secondary-font text-primary m-0">22</h3>
          <p class="secondary-font fs-6 m-0">Feb</p>

        </div>
        <div class="card position-relative">
          <a href="/client/single-post.html"><img src="/client/images/blog3.jpg" class="img-fluid rounded-4" alt="image"></a>
          <div class="card-body p-0">
            <a href="single-post.html">
              <h3 class="card-title pt-4 pb-3 m-0">Best home for your pets</h3>
            </a>

            <div class="card-text">
              <p class="blog-paragraph fs-6">At the core of our practice is the idea that cities are the incubators of
                our greatest
                achievements, and the best hope for a sustainable future.</p>
              <a href="/client/single-post.html" class="blog-read">read more</a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="service">
  <div class="container py-5 my-5">
    <div class="row g-md-5 pt-4">
      <div class="col-md-3 my-3">
        <div class="card">
          <div>
            <iconify-icon class="service-icon text-primary" icon="la:shopping-cart"></iconify-icon>
          </div>
          <h3 class="card-title py-2 m-0">Free Delivery</h3>
          <div class="card-text">
            <p class="blog-paragraph fs-6">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 my-3">
        <div class="card">
          <div>
            <iconify-icon class="service-icon text-primary" icon="la:user-check"></iconify-icon>
          </div>
          <h3 class="card-title py-2 m-0">100% secure payment</h3>
          <div class="card-text">
            <p class="blog-paragraph fs-6">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 my-3">
        <div class="card">
          <div>
            <iconify-icon class="service-icon text-primary" icon="la:tag"></iconify-icon>
          </div>
          <h3 class="card-title py-2 m-0">Daily Offer</h3>
          <div class="card-text">
            <p class="blog-paragraph fs-6">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 my-3">
        <div class="card">
          <div>
            <iconify-icon class="service-icon text-primary" icon="la:award"></iconify-icon>
          </div>
          <h3 class="card-title py-2 m-0">Quality guarantee</h3>
          <div class="card-text">
            <p class="blog-paragraph fs-6">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<section id="insta" class="my-5">
  <div class="row g-0 py-5">
    <div class="col instagram-item  text-center position-relative">
      <div class="icon-overlay d-flex justify-content-center position-absolute">
        <iconify-icon class="text-white" icon="la:instagram"></iconify-icon>
      </div>
      <a href="#">
        <img src="/client/images/insta1.jpg" alt="insta-img" class="img-fluid rounded-3">
      </a>
    </div>
    <div class="col instagram-item  text-center position-relative">
      <div class="icon-overlay d-flex justify-content-center position-absolute">
        <iconify-icon class="text-white" icon="la:instagram"></iconify-icon>
      </div>
      <a href="#">
        <img src="/client/images/insta2.jpg" alt="insta-img" class="img-fluid rounded-3">
      </a>
    </div>
    <div class="col instagram-item  text-center position-relative">
      <div class="icon-overlay d-flex justify-content-center position-absolute">
        <iconify-icon class="text-white" icon="la:instagram"></iconify-icon>
      </div>
      <a href="#">
        <img src="/client/images/insta3.jpg" alt="insta-img" class="img-fluid rounded-3">
      </a>
    </div>
    <div class="col instagram-item  text-center position-relative">
      <div class="icon-overlay d-flex justify-content-center position-absolute">
        <iconify-icon class="text-white" icon="la:instagram"></iconify-icon>
      </div>
      <a href="#">
        <img src="/client/images/insta4.jpg" alt="insta-img" class="img-fluid rounded-3">
      </a>
    </div>
    <div class="col instagram-item  text-center position-relative">
      <div class="icon-overlay d-flex justify-content-center position-absolute">
        <iconify-icon class="text-white" icon="la:instagram"></iconify-icon>
      </div>
      <a href="#">
        <img src="/client/images/insta5.jpg" alt="insta-img" class="img-fluid rounded-3">
      </a>
    </div>
    <div class="col instagram-item  text-center position-relative">
      <div class="icon-overlay d-flex justify-content-center position-absolute">
        <iconify-icon class="text-white" icon="la:instagram"></iconify-icon>
      </div>
      <a href="#">
        <img src="/client/images/insta6.jpg" alt="insta-img" class="img-fluid rounded-3">
      </a>
    </div>
  </div>
</section>

@endsection

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var categorySwiper = new Swiper('.category-products-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        rtl: true, // هماهنگی با راست‌چین بودن سایت
        loop: false, // اگر محصولات کم بود، چرخشی نشود تا باگ نزند
        navigation: {
            nextEl: '.category-next-btn',
            prevEl: '.category-prev-btn',
        },
        // حالت رسپانسیو برای نمایش در موبایل، تبلت و دسکتاپ
        breakpoints: {
            576: { slidesPerView: 2 },
            768: { slidesPerView: 3 },
            1024: { slidesPerView: 4 }
        }
    });
});
</script>



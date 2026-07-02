@extends('client.layout.master')


@section('content')

<section class="single-product-section py-5" style="direction: rtl; text-align: right;">
    <div class="container my-5">
        <div class="row g-5">
            
            <div class="col-12 col-md-6">
            <div class="product-gallery-wrapper">

                <div class="main-image-box p-4 bg-white rounded-4 border text-center mb-3 shadow-sm">
                    <img src="{{ asset('storage/' . $product->image) }}" id="current-main-img" alt="{{ $product->name }}" class="img-fluid rounded-4" style="max-height: 400px; object-fit: contain; width: 100%;">
                </div>

                <div class="thumbnail-images-row d-flex flex-wrap gap-2 justify-content-center">

                    <div class="thumb-item border rounded-3 p-1 bg-white" style="width: 70px; height: 70px; cursor: pointer;">
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-2 h-100 w-100" style="object-fit: cover;" onclick="changeMainImage(this.src)">
                    </div>

                    @if($product->pictures && $product->pictures->count() > 0)
                        @foreach($product->pictures as $picture)
                            <div class="thumb-item border rounded-3 p-1 bg-white" style="width: 70px; height: 70px; cursor: pointer;">
                                <img src="{{ asset('storage/' . $picture->path) }}" class="img-fluid rounded-2 h-100 w-100" style="object-fit: cover;" onclick="changeMainImage(this.src)">
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 d-flex flex-column justify-content-between">
            <div class="product-details">
                <span class="badge bg-dark-subtle text-secondary px-3 py-2 rounded-2 mb-3 fs-6">
                    {{ $product->category->title ?? 'بدون دسته‌بندی' }}
                </span>

                    <h1 class="fw-bold text-dark mb-3" style="font-size: 2.2rem;">
                        {{ $product->name }}
                    </h1>

                    <div class="rating-stars mb-4 text-warning fs-5">
                        <iconify-icon icon="clarity:star-solid"></iconify-icon>
                        <iconify-icon icon="clarity:star-solid"></iconify-icon>
                        <iconify-icon icon="clarity:star-solid"></iconify-icon>
                        <iconify-icon icon="clarity:star-solid"></iconify-icon>
                        <iconify-icon icon="clarity:star-solid"></iconify-icon>
                        <span class="text-dark small ms-2">(۵.۰)</span>
                    </div>

                    @auth
                    <div class="mt-3">
                        <button type="button" class="btn btn-sm btn-outline-danger w-100 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#reportModal">
                             گزارش تخلف این آگهی
                        </button>
                    </div>
                @else
                    <div class="mt-3">
                        <a href="{{ route('client.register.store') }}" class="btn btn-sm btn-outline-secondary w-100 py-2 fw-bold">
                            برای ثبت گزارش ابتدا وارد شوید
                        </a>
                    </div>
                @endauth

                    <div id="price-display-box" class="price-container p-3 bg-light rounded-3 d-inline-block mb-4 border border-light-subtle">
                        
                    @if($product->has_discount)
                        <span class="text-muted text-decoration-line-through me-3 fs-5" style="text-decoration: line-through;">
                            {{ number_format($product->cost) }}
                        </span>
                        
                        <h2 class="text-danger d-inline fw-bold m-0 fs-3">
                            {{ number_format($product->with_discount) }}
                        </h2>
                        
                        <span class="badge bg-danger text-white ms-2 px-2 py-1 rounded-pill">
                            {{ $product->discount_value }}% تخفیف
                        </span>

                    @else
                        <h2 class="text-primary fw fw-bold m-0 fs-3">
                            {{ number_format(($product->cost)) }}
                        </h2>
                    @endif
                        <small class="text-muted mr-1">تومان</small>
                    </div>

                    <div class="product-description my-4">
                        <h5 class="fw-bold text-dark mb-2">توضیحات محصول</h5>
                        <p class="text-muted lh-lg" style="font-size: 1.05rem; text-align: justify;">
                           {{ $product->description }}
                        </p>
                    </div>

                </div>

                @if($product->variations && $product->variations->where('color_name', '!=', null)->count() > 0)
    <div class="mb-4 text-end" style="direction: rtl;">
        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2 justify-content-start">
            <iconify-icon icon="solar:palette-linear" class="text-secondary fs-5"></iconify-icon>
            انتخاب رنگ:
        </h6>
        <div class="d-flex flex-wrap gap-2 justify-content-start">
            @foreach($product->variations->unique('color_name') as $variation)
                <label class="btn btn-outline-secondary btn-sm rounded-pill d-flex align-items-center gap-2 px-3 py-2 cursor-pointer">
                    <input type="radio" name="product_color" 
                           value="{{ $variation->id }}" 
                           data-image="{{ asset('storage/' . $variation->image) }}"
                           data-cost="{{ $variation->price ? number_format($variation->price) : 0 }}"
                           data-has-discount="{{ $variation->has_discount ? '1' : '0' }}"
                           data-discount-cost="{{ $variation->with_discount ? number_format($variation->with_discount) : 0 }}"
                           data-discount-value="{{ $variation->discount_value ?? 0 }}"
                           data-stock="{{ $variation->stock ?? 0 }}" {{-- 👈 اضافه شدن دیتای موجودی تنوع --}}
                           onchange="changeProductDetails(this)"
                           class="form-check-input m-0">
                    <span class="rounded-circle border" style="display: inline-block; width: 14px; height: 14px; background-color: {{ $variation->color_code }};"></span>
                    {{ $variation->color_name }}
                </label>
            @endforeach
        </div>
    </div>
@endif
@php
    // بررسی اینکه آیا محصول اصلاً تنوع (رنگ) دارد یا خیر
    $hasVariations = $product->variations->count() > 0;
@endphp

<!-- تگ باز شدن دیو اصلی به همراه بسته شدن علامت منقارک < در انتها -->
<div class="my-3 text-start" id="stock-container" style="direction: rtl; {{ $hasVariations ? 'display: none !important;' : '' }}">
    <span class="text-dark fw-bold fs-6">وضعیت موجودی در انبار:</span>
    
    <span id="stock-display" class="badge bg-success text-dark ms-2 px-3 py-2 fs-6 rounded-3 shadow-sm" style="display: inline-block; min-width: 120px;">
        @if(!$hasVariations)
            @if($product->stock > 0)
                {{ $product->stock }} عدد موجود است
            @else
                ناموجود
            @endif
        @endif
    </span>
</div>


<div class="product-actions border-top pt-4 mt-auto" style="direction: rtl;">
    <div class="d-flex align-items-center flex-wrap gap-3 justify-content-start">
        
        <!-- باکس شیک انتخاب تعداد محصول -->
        <div class="quantity-wrapper d-flex align-items-center border rounded-3 bg-light" style="padding: 4px 8px; max-width: 140px;">
            <button type="button" class="btn btn-sm p-2 text-dark border-0 bg-transparent fw-bold fs-5" id="decrease-qty-btn" onclick="changeQuantityValue(-1)">-</button>
            <input type="number" id="product-quantity-input" class="form-control text-center border-0 bg-transparent p-0 m-0 fw-bold fs-5" value="1" min="1" style="width: 50px; box-shadow: none; pointer-events: none;">
            <button type="button" class="btn btn-sm p-2 text-dark border-0 bg-transparent fw-bold fs-5" id="increase-qty-btn" onclick="changeQuantityValue(1)">+</button>
        </div>

        <!-- دکمه افزودن به سبد خرید (دیتا اتریبیوت data-quantity به آن اضافه شده است) -->
        <a href="#" class="btn-cart px-4 pt-3 pb-3 add-to-cart-btn d-flex align-items-center justify-content-center m-0" id="main-add-to-cart-btn" data-id="{{ $product->id }}" data-quantity="1" style="height: 48px;">
            <h5 class="text-uppercase m-0">افزودن به سبد خرید</h5>
        </a>

        <!-- دکمه لایک -->
        <a href="#" class="btn-wishlist px-3 d-flex align-items-center justify-content-center border rounded-3" style="height: 48px; min-width: 48px;">
            <iconify-icon id="like-{{ $product->id }}" 
              class="fa fa-heart @if($product->is_liked) like @endif" 
              onclick="like({{ $product->id }})" icon="fluent:heart-28-filled" class="fs-5"></iconify-icon>
        </a>
        
    </div>
</div>

            </div>

        </div>


        @if($product->properties && $product->properties->count() > 0)
        <div class="product-properties-section mt-5 border-top pt-4">
            <h4 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
                <iconify-icon icon="fluent:text-bullet-list-square-24-regular" class="text-primary"></iconify-icon>
              ویژگی‌های محصول
            </h4>
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <tbody>
                                @foreach($product->properties as $property)
                                <tr>
                                    <td class="bg-light fw-bold text-dark" style="width: 30%;">
                                        {{ $property->title ?? $property->name }}
                                    </td>
                                    <td class="text-dark">
                                        {{ $property->pivot->value ?? 'ثبت نشده' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
    <div class="product-comments-section mt-5 border-top pt-5">
        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                
                <div class="comment-form-box p-4 bg-light rounded-4 border mb-5 shadow-sm">
                    <h4 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2" style="font-size: 1.3rem;">
                        <iconify-icon icon="fluent:comment-add-24-regular" class="text-primary fs-4"></iconify-icon>
                        ثبت دیدگاه یا نظر جدید
                    </h4>
                    
                    @auth
                        <form id="addTagForm" action="{{ route('client.products.comments.store', $product) }}" method="post">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="text" class="form-label fw-medium  mb-2">متن دیدگاه شما:</label>
                                <textarea class="form-control rounded-3 p-3 border-light-subtle" name="text" id="text" rows="4" placeholder="نظرات، پیشنهادات یا تجربیات خود را در مورد این محصول بنویسید..." required style="resize: none;"></textarea>
                            </div> 
                            <div class="text-start">
                                <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-bold shadow-sm">
                                    ثبت و ارسال نظر
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning border-0 rounded-3 d-flex align-items-center gap-2 m-0" role="alert">
                            <iconify-icon icon="solar:info-circle-bold" class="fs-4"></iconify-icon>
                            <span>برای ثبت نظر، ابتدا باید <a href="{{ route('client.register') }}" class="fw-bold text-decoration-none text-dark border-bottom border-dark">وارد حساب کاربری</a> خود شوید.</span>
                        </div>
                    @endauth
                </div>

                <div class="comments-list-box">
                    <h4 class="fw-bold mb-4 d-flex align-items-center gap-2" style="font-size: 1.3rem; color: #5c3a21;">
                        <iconify-icon icon="fluent:comment-multiple-24-regular" class="fs-4" style="color: #db7c34"></iconify-icon>
                        نظرات کاربران ({{ $product->comments->count() }})
                    </h4>

                    @forelse ($product->comments()->latest()->get() as $comment)
                        <div class="card border-0 shadow-sm rounded-4 p-4 mb-3" style="background-color: #fdfbf7; border-right: 5px solid #db7c34 !important; border: 1px solid #f1eae0;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="user-info d-flex align-items-center gap-2">
                                    <iconify-icon icon="solar:user-circle-bold" class="text-secondary fs-3"></iconify-icon>
                                    <span class="fw-bold " style="font-size: 0.95rem; color: #3d2516;">{{ $comment->user->name ?? 'کاربر ناشناس' }}</span>
                                </div>
                                <small class="text-muted d-flex align-items-center gap-1" style="font-size: 0.85rem;">
                                    <iconify-icon icon="fluent:clock-24-regular"></iconify-icon>
                                    {{ $comment->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <div class="comment-text lh-lg" style="font-size: 0.95rem; text-align: justify; color: #4a3321; font-weight: 500;">
                                {{ $comment->text }}
                            </div>
                        </div>
                    @empty
                    <div class="text-center text-muted py-5 rounded-4 border border-dashed bg-white">
                        <iconify-icon icon="fluent:chat-dismiss-24-regular" class="fs-1 text-light-subtle mb-2"></iconify-icon>
                        <p class="m-0" style="font-size: 0.95rem;">هنوز هیچ دیدگاهی برای این محصول ثبت نشده است. اولین نظردهنده شما باشید!</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
</section>

@endsection

    
    <script>
        // ۱. تغییر عکس با کلیک روی گالری تصاویر کوچک
        function changeMainImage(src) {
            document.getElementById('current-main-img').src = src;
        }
    
        // ۲. تابع هوشمند برای تغییر عکس، قیمت و موجودی انبار با انتخاب رنگ
        function changeProductDetails(element) {
            
            // الف) تغییر عکس محصول به عکسِ مخصوصِ آن رنگ
            var newImgSrc = element.getAttribute('data-image');
            if (newImgSrc && newImgSrc.trim() !== "") {
                document.getElementById('current-main-img').src = newImgSrc;
            }
    
            // ب) دریافت اطلاعات قیمت و تخفیف از رادیو باتن کلیک شده
            var cost = element.getAttribute('data-cost');
            var hasDiscount = element.getAttribute('data-has-discount');
            var discountCost = element.getAttribute('data-discount-cost');
            var discountValue = element.getAttribute('data-discount-value');
            
            var priceBox = document.getElementById('price-display-box');
            
            if (priceBox) {
                if (hasDiscount === '1') {
                    // نمایش قیمت در صورت داشتن تخفیف
                    priceBox.innerHTML = `
                        <span class="text-muted text-decoration-line-through me-3 fs-5" style="text-decoration: line-through;">${cost}</span>
                        <h2 class="text-danger d-inline fw-bold m-0 fs-3">${discountCost}</h2>
                        <span class="badge bg-danger text-white ms-2 px-2 py-1 rounded-pill">${discountValue}% تخفیف</span>
                        <small class="text-muted mr-1">تومان</small>
                    `;
                } else {
                    // نمایش قیمت معمولی بدون تخفیف
                    priceBox.innerHTML = `
                        <h2 class="text-primary fw fw-bold m-0 fs-3">${cost}</h2>
                        <small class="text-muted mr-1">تومان</small>
                    `;
                }
            }
    
            // ج) تغییر تعداد موجودی انبار بر اساس رنگ انتخابی با ریست شدن کلاس‌ها //
            var stock = parseInt(element.getAttribute('data-stock')) || 0; // تغییر به parseInt دقیق
            var stockDisplay = document.getElementById('stock-display');
            var stockContainer = document.getElementById('stock-container'); //  اضافه کردن کانتینر اصلی
            var addToCartBtn = document.querySelector('.btn-danger'); 

            if (stockDisplay) {
          //  به محض انتخاب یک رنگ، کادر وضعیت انبار را آشکار کن
         if (stockContainer) {
            stockContainer.style.setProperty('display', 'block', 'important');
         }
    
         stockDisplay.className = "";
                
                if (stock > 0) {
                    // اگر محصول در این رنگ موجود بود (باکس سبز)
                    stockDisplay.innerHTML = stock + " عدد در انبار موجود است";
                    stockDisplay.className = "badge bg-success text-dark ms-2 px-3 py-2 fs-6 rounded-3 shadow-sm"; 
                    
                    if (addToCartBtn) {
                        addToCartBtn.disabled = false;
                        addToCartBtn.innerHTML = `<iconify-icon icon="solar:cart-large-minimalistic-bold" class="fs-4"></iconify-icon> افزودن به سبد خرید`;
                    }
                } else {
                    // اگر موجودی این رنگ صفر بود (باکس قرمز)
                    stockDisplay.innerHTML = "ناموجود";
                    stockDisplay.className = "badge bg-danger text-white ms-2 px-3 py-2 fs-6 rounded-3 shadow-sm"; 
                    
                    if (addToCartBtn) {
                        addToCartBtn.disabled = true;
                        addToCartBtn.innerHTML = "این رنگ ناموجود است";
                    }
                }
            }
        }
    </script>

<script>
    // ۱. مدیریت دکمه‌های پلاس و ماینس تعداد محصول اصلی
    function changeQuantityValue(change) {
        const qtyInput = document.getElementById('product-quantity-input');
        const addToCartBtn = document.getElementById('main-add-to-cart-btn');
        if (!qtyInput || !addToCartBtn) return;
    
        let currentVal = parseInt(qtyInput.value) || 1;
        let newVal = currentVal + change;
    
        if (newVal < 1) newVal = 1;
    
        qtyInput.value = newVal;
        addToCartBtn.setAttribute('data-quantity', newVal);
    }
    
    // ۲. تغییر عکس با کلیک روی گالری تصاویر کوچک
    function changeMainImage(src) {
        const mainImg = document.getElementById('current-main-img');
        if (mainImg) {
            mainImg.src = src;
        }
    }

    // ۳. تغییر عکس، قیمت، موجودی انبار و وضعیت دکمه‌ها با انتخاب رنگ
    function changeProductDetails(element) {
        if (!element) return;

        // الف) تغییر عکس مخصوص به آن رنگ
        var newImgSrc = element.getAttribute('data-image');
        var mainImg = document.getElementById('current-main-img');
        if (mainImg && newImgSrc && newImgSrc.trim() !== "") {
            mainImg.src = newImgSrc;
        }
    
        // ب) تغییرات بخش قیمت و تخفیف
        var cost = element.getAttribute('data-cost');
        var hasDiscount = element.getAttribute('data-has-discount');
        var discountCost = element.getAttribute('data-discount-cost');
        var discountValue = element.getAttribute('data-discount-value');
        
        var priceBox = document.getElementById('price-display-box');
        
        if (priceBox) {
            if (hasDiscount === '1') {
                priceBox.innerHTML = `
                    <span class="text-muted text-decoration-line-through me-3 fs-5" style="text-decoration: line-through;">${cost}</span>
                    <h2 class="text-danger d-inline fw-bold m-0 fs-3">${discountCost}</h2>
                    <span class="badge bg-danger text-white ms-2 px-2 py-1 rounded-pill">${discountValue}% تخفیف</span>
                    <small class="text-muted mr-1">تومان</small>
                `;
            } else {
                priceBox.innerHTML = `
                    <h2 class="text-primary fw fw-bold m-0 fs-3">${cost}</h2>
                    <small class="text-muted mr-1">تومان</small>
                `;
            }
        }
    
        // ج) مدیریت وضعیت انبار و دکمه افزودن (بدون تداخل با سبد خرید)
        var stock = parseInt(element.getAttribute('data-stock')) || 0;
        var stockDisplay = document.getElementById('stock-display');
        var stockContainer = document.getElementById('stock-container');
        
        // استفاده از ID اختصاصی دکمه اصلی برای جلوگیری از تداخل با دکمه‌های حذف سبد خرید
        var addToCartBtn = document.getElementById('main-add-to-cart-btn'); 
        
        const decreaseBtn = document.getElementById('decrease-qty-btn');
        const increaseBtn = document.getElementById('increase-qty-btn');
        const qtyInput = document.getElementById('product-quantity-input');
    
        if (stockDisplay) {
            if (stock > 0) {
                // نمایش کادر انبار در صورت موجود بودن
                if (stockContainer) { stockContainer.style.display = 'block'; }
                stockDisplay.innerHTML = stock + " عدد در انبار موجود است";
                stockDisplay.className = "badge bg-success text-dark ms-2 px-3 py-2 fs-6 rounded-3 shadow-sm"; 
                
                if (addToCartBtn) {
                    addToCartBtn.removeAttribute('disabled');
                    addToCartBtn.style.pointerEvents = 'auto';
                    addToCartBtn.style.opacity = '1';
                    var h5Text = addToCartBtn.querySelector('h5');
                    if (h5Text) { h5Text.innerHTML = "افزودن به سبد خرید"; } else { addToCartBtn.innerHTML = "افزودن به سبد خرید"; }
                }
                if (decreaseBtn) decreaseBtn.disabled = false;
                if (increaseBtn) increaseBtn.disabled = false;
                
            } else {
                // مخفی کردن کادر انبار در صورت ناموجود بودن رنگ
                if (stockContainer) { stockContainer.style.display = 'none'; }
                
                if (addToCartBtn) {
                    addToCartBtn.setAttribute('disabled', 'disabled');
                    addToCartBtn.style.pointerEvents = 'none';
                    addToCartBtn.style.opacity = '0.5';
                    var h5Text = addToCartBtn.querySelector('h5');
                    if (h5Text) { h5Text.innerHTML = "این رنگ ناموجود است"; } else { addToCartBtn.innerHTML = "این رنگ ناموجود است"; }
                }
                if (decreaseBtn) decreaseBtn.disabled = true;
                if (increaseBtn) increaseBtn.disabled = true;
                if (qtyInput) qtyInput.value = 1;
            }
        }
    }

    // ۴. بررسی وضعیت انبار محصولات ساده در بدو ورود به صفحه
    document.addEventListener("DOMContentLoaded", function() {
        const hasColorInputs = document.querySelector('input[name="product_color"]');
        const stockContainer = document.getElementById('stock-container');
        const stockDisplay = document.getElementById('stock-display');
        
        if (!hasColorInputs && stockContainer && stockDisplay) {
            const mainStock = parseInt("{{ $product->stock ?? 0 }}") || 0;
            
            if (mainStock > 0) {
                stockContainer.style.display = 'block';
                stockDisplay.innerHTML = mainStock + " عدد در انبار موجود است";
                stockDisplay.className = "badge bg-success text-dark ms-2 px-3 py-2 fs-6 rounded-3 shadow-sm";
            } else {
                stockContainer.style.display = 'none';
            }
        }
    });
</script>

<!-- Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true" dir="rtl">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-dark" id="reportModalLabel">گزارش تخلف آگهی</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('client.products.report', $product->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted small">لطفاً علت گزارش خود را انتخاب کنید تا ادمین‌ها سریع‌تر بررسی کنند.</p>
                    
                    <!-- انتخاب علت تخلف -->
                    <div class="mb-3" dir="rtl">
                        <label for="reason" class="form-label fw-bold small">علت گزارش <span class="text-danger">*</span></label>
                        <select class="form-select" name="reason" id="reason" required>
                            <option value="">-- انتخاب کنید --</option>
                            <option value="اطلاعات نادرست یا فیک">اطلاعات نادرست یا فیک</option>
                            <option value="قیمت نامناسب یا نامتعارف">قیمت نامناسب یا نامتعارف</option>
                            <option value="کلاهبرداری یا موارد مشکوک">کلاهبرداری یا موارد مشکوک</option>
                            <option value="محتوای نامناسب یا غیراخلاقی">محتوای نامناسب یا غیراخلاقی</option>
                            <option value="آگهی تکراری">آگهی تکراری</option>
                        </select>
                    </div>

                    <!-- توضیحات تکمیلی -->
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold small">توضیحات تکمیلی (اختیاری)</label>
                        <textarea class="form-textarea form-control" name="description" id="description" rows="4" placeholder="جزئیات بیشتری که فکر می‌کنید ادمین باید بداند را بنویسید..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-danger">ثبت و ارسال گزارش</button>
                </div>
            </form>
        </div>
    </div>
</div>
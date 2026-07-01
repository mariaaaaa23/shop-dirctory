<!DOCTYPE html>
<html lang="en">

<head>
  <title>Waggy - Admin Panel</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  
  <meta name="format-detection" content="telephone=no">
  <meta name="author" content="">
  
<link rel="stylesheet" href="{{ asset('/client/css/auth.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="{{ asset('/client/css/vendor.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/client/style.css') }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Chilanka&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />




<style>
  .like{
    color: red ;
  }
</style>

</head>

<body>

  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <defs>
    
      <symbol xmlns="http://www.w3.org/2000/svg" id="link" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M12 19a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0-4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm-5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm7-12h-1V2a1 1 0 0 0-2 0v1H8V2a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3Zm1 17a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-9h16Zm0-11H4V6a1 1 0 0 1 1-1h1v1a1 1 0 0 0 2 0V5h8v1a1 1 0 0 0 2 0V5h1a1 1 0 0 1 1 1ZM7 15a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0 4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Z" />
          
        </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="arrow-right" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M17.92 11.62a1 1 0 0 0-.21-.33l-5-5a1 1 0 0 0-1.42 1.42l3.3 3.29H7a1 1 0 0 0 0 2h7.59l-3.3 3.29a1 1 0 0 0 0 1.42a1 1 0 0 0 1.42 0l5-5a1 1 0 0 0 .21-.33a1 1 0 0 0 0-.76Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="category" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M19 5.5h-6.28l-.32-1a3 3 0 0 0-2.84-2H5a3 3 0 0 0-3 3v13a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-10a3 3 0 0 0-3-3Zm1 13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-13a1 1 0 0 1 1-1h4.56a1 1 0 0 1 .95.68l.54 1.64a1 1 0 0 0 .95.68h7a1 1 0 0 1 1 1Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="calendar" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M19 4h-2V3a1 1 0 0 0-2 0v1H9V3a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3Zm1 15a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-7h16Zm0-9H4V7a1 1 0 0 1 1-1h2v1a1 1 0 0 0 2 0V6h6v1a1 1 0 0 0 2 0V6h2a1 1 0 0 1 1 1Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="heart" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M20.16 4.61A6.27 6.27 0 0 0 12 4a6.27 6.27 0 0 0-8.16 9.48l7.45 7.45a1 1 0 0 0 1.42 0l7.45-7.45a6.27 6.27 0 0 0 0-8.87Zm-1.41 7.46L12 18.81l-6.75-6.74a4.28 4.28 0 0 1 3-7.3a4.25 4.25 0 0 1 3 1.25a1 1 0 0 0 1.42 0a4.27 4.27 0 0 1 6 6.05Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="plus" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M19 11h-6V5a1 1 0 0 0-2 0v6H5a1 1 0 0 0 0 2h6v6a1 1 0 0 0 2 0v-6h6a1 1 0 0 0 0-2Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="minus" viewBox="0 0 24 24">
        <path fill="currentColor" d="M19 11H5a1 1 0 0 0 0 2h14a1 1 0 0 0 0-2Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="cart" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M8.5 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 8.5 19ZM19 16H7a1 1 0 0 1 0-2h8.491a3.013 3.013 0 0 0 2.885-2.176l1.585-5.55A1 1 0 0 0 19 5H6.74a3.007 3.007 0 0 0-2.82-2H3a1 1 0 0 0 0 2h.921a1.005 1.005 0 0 1 .962.725l.155.545v.005l1.641 5.742A3 3 0 0 0 7 18h12a1 1 0 0 0 0-2Zm-1.326-9l-1.22 4.274a1.005 1.005 0 0 1-.963.726H8.754l-.255-.892L7.326 7ZM16.5 19a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="check" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M18.71 7.21a1 1 0 0 0-1.42 0l-7.45 7.46l-3.13-3.14A1 1 0 1 0 5.29 13l3.84 3.84a1 1 0 0 0 1.42 0l8.16-8.16a1 1 0 0 0 0-1.47Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="trash" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M10 18a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1ZM20 6h-4V5a3 3 0 0 0-3-3h-2a3 3 0 0 0-3 3v1H4a1 1 0 0 0 0 2h1v11a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8h1a1 1 0 0 0 0-2ZM10 5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v1h-4Zm7 14a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8h10Zm-3-1a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="star-outline" viewBox="0 0 15 15">
        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
          d="M7.5 9.804L5.337 11l.413-2.533L4 6.674l2.418-.37L7.5 4l1.082 2.304l2.418.37l-1.75 1.793L9.663 11L7.5 9.804Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="star-solid" viewBox="0 0 15 15">
        <path fill="currentColor"
          d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="search" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="user" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M15.71 12.71a6 6 0 1 0-7.42 0a10 10 0 0 0-6.22 8.18a1 1 0 0 0 2 .22a8 8 0 0 1 15.9 0a1 1 0 0 0 1 .89h.11a1 1 0 0 0 .88-1.1a10 10 0 0 0-6.25-8.19ZM12 12a4 4 0 1 1 4-4a4 4 0 0 1-4 4Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="close" viewBox="0 0 15 15">
        <path fill="currentColor"
          d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z" />
      </symbol>

    </defs>
  </svg>

  <div class="preloader-wrapper">
    <div class="preloader">
      <script src="{{ asset('client/js/jquery-1.11.0.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('client/js/plugins.js') }}"></script>
  <script src="{{ asset('client/js/script.js') }}"></script>

  <div class="modal fade" id="cityModal" tabindex="-1" aria-labelledby="cityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="cityModalLabel">📍 انتخاب محدوده آگهی‌ها</h5>
                <button type="button" class="btn-close m-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-right" dir="rtl">
                <div class="mb-3">
                    <label class="form-label fw-bold">استان:</label>
                    <select id="modal-province-select" onchange="loadModalCities(this.value)" class="form-select">
                        <option value="">-- انتخاب استان --</option>
                        @foreach(\App\Models\State::all() as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">شهر:</label>
                    <select id="modal-city-select" onchange="enableModalSaveBtn(this.value)" class="form-select" disabled>
                        <option value="">-- ابتدا استان را انتخاب کنید --</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                <button type="button" id="btn-save-city" onclick="applyModalCityFilter()" class="btn btn-primary" disabled>تایید و اعمال فیلتر</button>
            </div>
        </div>
    </div>
</div>

</body>
    </div>
  </div>

  <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart" aria-labelledby="My Cart">
    <div class="offcanvas-header justify-content-center">
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="order-md-last">
        
        @php
          $cartDetails = \App\Models\CartItem::getCartDetails();
        @endphp
    
        <h4 class="d-flex justify-content-between align-items-center mb-3" style="direction: rtl;">
          <span class="text-primary">سبد خرید شما</span>
          <span class="badge bg-primary rounded-circle pt-2 cart-count-badge">{{ $cartDetails['total_count'] }}</span>
        </h4>
        
        <ul class="list-group mb-3" style="direction: rtl; text-align: right;">
          @forelse($cartDetails['items'] as $item)
            <li class="list-group-item d-flex justify-content-between lh-sm align-items-center py-3">
              
              <div class="d-flex align-items-center">
                @if($item['image'])
                  <img src="{{ asset('storage/' . $item['image']) }}" class="rounded me-2" style="width: 50px; height: 50px; object-fit: cover;">
                @endif
                <div>
                  <h6 class="my-0 font-weight-bold">{{ $item['name'] }}</h6>
                  @if(!empty($item['color_name']))
                     <span class="text-muted d-block mt-1" style="font-size: 11px;">رنگ: {{ $item['color_name'] }}</span>
                  @endif
                  <small class="text-body-secondary">{{ $item['quantity'] }} عدد</small>
                </div>
              </div>
              
              <div class="d-flex align-items-center gap-3">
                <span class="text-body-secondary fw-semibold">{{ number_format($item['sub_total']) }} تومان</span>
                
                <button type="button" class="btn btn-sm text-danger remove-from-cart-btn p-0" data-id="{{ $item['id'] }}" style="background: none; border: none; line-height: 1;">
                  <iconify-icon icon="mdi:close-circle" class="fs-4"></iconify-icon>
                </button>
              </div>
    
            </li>
          @empty
            <li class="list-group-item text-center py-4 text-muted">
              سبد خرید شما خالی است 
            </li>
          @endforelse
    
          <li class="list-group-item d-flex justify-content-between">
            <span class="fw-bold">جمع کل (تومان)</span>
            <strong class="text-primary">{{ number_format($cartDetails['total_price']) }}</strong>
          </li>
          
        </ul>
    
        @if($cartDetails['total_count'] > 0)
          <a href="{{ route('client.checkout.index') }}" class="w-100 btn btn-primary btn-lg d-block text-conter text-white fw-bold py-3" style="background-color: #d1a84b; border: none; border-radius: 12px;">تسویه حساب</a>
        @endif
      </div>
    </div>
  </div>

  <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasSearch"
    aria-labelledby="Search">
    <div class="offcanvas-header justify-content-center">
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

      <div class="order-md-last">
        <h4 class="text-primary text-uppercase mb-3">
          Search
        </h4>
        <div class="search-bar border rounded-2 border-dark-subtle">
          <form id="search-form" class="text-center d-flex align-items-center" action="" method="">
            <input type="text" class="form-control border-0 bg-transparent" placeholder="Search Here" />
            <iconify-icon icon="tabler:search" class="fs-4 me-3"></iconify-icon>
          </form>
        </div>
      </div>
    </div>
  </div>

  <header>
    <div class="container py-2">
      <div class="row py-4 pb-0 pb-sm-4 align-items-center ">

        <div class="col-sm-4 col-lg-3 text-center text-sm-start">
          <div class="main-logo">
            <a href="/client/index.html">
              <img src="/client/images/logo.png" alt="logo" class="img-fluid">
            </a>
          </div>
        </div>

        <div class="col-sm-6 offset-sm-2 offset-md-0 col-lg-5 d-none d-lg-block">
          <div class="search-bar border rounded-2 px-3 border-dark-subtle">
            <form id="search-form" class="text-center d-flex align-items-center" action="" method="">
              <input type="text" class="form-control border-0 bg-transparent"
                placeholder="Search for more than 10,000 products" />
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="currentColor"
                  d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
              </svg>
            </form>
          </div>
        </div>

        <div class="d-inline-flex align-items-center bg-white border rounded-pill px-3 py-1 shadow-sm ms-5" style="height: 45px; border-color: #e2e8f0 !important;">
          <span class="text-danger me-2 d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                  <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
              </svg>
          </span>
      
          <select id="province-select" onchange="loadCities(this.value)" class="form-select form-select-sm border-0 bg-transparent p-0 pe-4 fw-medium text-dark" style="font-size: 0.85rem; min-width: 90px; cursor: pointer; box-shadow: none;">
              <option value="">انتخاب استان</option>
              @foreach($provinces as $province)
                  <option value="{{ $province->id }}" {{ session('selected_province_id') == $province->id ? 'selected' : '' }}>
                      {{ $province->name }}
                  </option>
              @endforeach
          </select>
      
          <span class="text-dark mx-2 opacity-25">|</span>
      
          <select id="city-select" onchange="applyCityFilter(this.value)" class="form-select form-select-sm border-0 bg-transparent p-0 pe-4 fw-medium text-dark" style="font-size: 0.85rem; min-width: 90px; cursor: pointer; box-shadow: none;" {{ session('selected_province_id') ? '' : 'disabled' }}>
              <option value="">انتخاب شهر</option>
              @if(session('selected_city_id'))
                  @php $currentCity = \App\Models\City::find(session('selected_city_id')); @endphp
                  @if($currentCity)
                      <option value="{{ $currentCity->id }}" selected>{{ $currentCity->name }}</option>
                  @endif
              @endif
          </select>
      </div>

          <div class="support-box text-end d-none d-xl-block">
            <span class="fs-6 secondary-font text-muted">Email</span>
            <h5 class="mb-0">waggy@gmail.com</h5>
          </div>



        </div>
      </div>
    </div>

    <div class="container-fluid">
      <hr class="m-0">
    </div>

    <div class="container">
      <nav class="main-menu d-flex navbar navbar-expand-lg ">

        <div class="d-flex d-lg-none align-items-end mt-3">
          <ul class="d-flex justify-content-end list-unstyled m-0">
            <li>
              <a href="/client/account.html" class="mx-3">
                <iconify-icon icon="healthicons:person" class="fs-4"></iconify-icon>
              </a>
            </li>
            <li>
              <a href="/client/wishlist.html" class="mx-3">
                <iconify-icon icon="mdi:heart" class="fs-4"></iconify-icon>
              </a>
            </li>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
              <div class="offcanvas-header justify-content-center">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              
              <ul class="d-flex list-unstyled m-0 align-items-center">
                <li>
                  <a href="#" class="mx-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearch" aria-controls="offcanvasSearch">
                    <iconify-icon icon="tabler:search" class="fs-4"></iconify-icon>
                  </a>
                </li>
              
                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart" class="position-relative">
                  <iconify-icon icon="cyber:cart" class="fs-4"></iconify-icon>
                
                  <span class="cart-count-badge badge bg-primary rounded-circle position-absolute"></span>
                </a>
              </ul>
            </div>

            <li>
              <a href="#" class="mx-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearch"
                aria-controls="offcanvasSearch">
                <iconify-icon icon="tabler:search" class="fs-4"></iconify-icon>
                </span>
              </a>
            </li>
          </ul>

        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
          aria-controls="offcanvasNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">

          <div class="offcanvas-header justify-content-center">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>

          <div class="offcanvas-body justify-content-between">

            @include('client.layout.menu')    
            
            <ul class="navbar-nav menu-list list-unstyled d-flex gap-md-3 mb-0">
              <li class="nav-item">
                <a href="/client/index.html" class="nav-link active">Home</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" role="button" id="pages" data-bs-toggle="dropdown"
                  aria-expanded="false">Pages</a>
                <ul class="dropdown-menu" aria-labelledby="pages">
                  <li><a href="/client/index.html" class="dropdown-item">About Us</a></li>
                  <li><a href="/client/index.html" class="dropdown-item">Shop</a></li>
                  <li><a href="/client/index.html" class="dropdown-item">Single Product</a></li>
                  <li><a href="index.html" class="dropdown-item">Cart</a></li>
                  <li><a href="/client/index.html" class="dropdown-item">Wishlist</a></li>
                  <li><a href="/client/index.html" class="dropdown-item">Checkout</a></li>
                  <li><a href="index.html" class="dropdown-item">Blog</a></li>
                  <li><a href="/client/index.html" class="dropdown-item">Single Post</a></li>
                  <li><a href="/client/index.html" class="dropdown-item">Contact</a></li>
                  <li><a href="/client/index.html" class="dropdown-item">FAQs</a></li>
                  <li><a href="/client/index.html" class="dropdown-item">Account</a></li>
                  <li><a href="/client/index.html" class="dropdown-item">Thankyou</a></li>
                  <li><a href="/client/.html" class="dropdown-item">Error 404</a></li>
                  <li><a href="/client/.html" class="dropdown-item">Styles</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="/client/index.html" class="nav-link">Shop</a>
              </li>

              @auth
              @if(auth()->user()->hasRole('admin'))
                  {{-- ۱. منوی مخصوص ادمین سایت --}}
                  <li class="nav-item">
                      <a href="/adminpanel" class="nav-link fw-bold text-dark"> پنل مدیریت (ادمین)</a>
                  </li>
          
              @elseif(auth()->user()->hasRole('author'))
                  {{-- ۲. منوی مخصوص نویسنده‌های تایید شده (اینجا اصلاح شد) --}}
                  <li class="nav-item">
                      <a href="{{ route('author.products.index') }}" class="nav-link fw-bold text-primary">آگهی‌های من</a>
                  </li>
          
              @elseif(auth()->user()->status == 'pending')
                  {{-- ۳. وضعیت کاربران عادی که دکمه را زده‌اند و منتظر تایید هستند --}}
                  <li class="nav-item">
                      <span class="nav-link text-dark"> در انتظار تأیید نویسندگی</span>
                  </li>
          
              @else
                  {{-- ۴. کاربران عادی که هنوز درخواستی ارسال نکرده‌اند --}}
                  <li class="nav-item">
                      <form action="{{ route('client.request.author') }}" method="POST" class="d-inline">
                          @csrf
                          <button type="submit" class="btn nav-link text-dark fw-bold" style="border: none; background: none;">
                               درخواست پنل نویسندگی
                          </button>
                      </form>
                  </li>
              @endif
          @else
              {{-- اگر کاربر مهمان بود و اصلاً لاگین نکرده بود --}}
              <li class="nav-item">
                  <a href="/client/index.html" class="nav-link">Blog</a>
              </li>
          @endauth
              
              <li class="nav-item">
                
                @auth
                    <li class="nav-item d-flex align-items-center" style="list-style: none;">
                    <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background-color: #f5efe6; border: 1px solid #e1d7c6;">
                    <span class="fw-bold" style="font-size: 0.9rem; color: #3d2516;">
                    <iconify-icon icon="solar:user-bold" class="fs-5" style="vertical-align: middle; color: #db7c34;"></iconify-icon>
                       {{ auth()->user()->name }}
                    </span>
            
                    <span style="color: #c5b6a0;">|</span>
            
                  <form action="{{ route('client.logout') }}" method="POST" class="m-0 p-0 d-inline">
                 @csrf
                 @method('DELETE')
                  <button type="submit" class="btn p-0 border-0 bg-transparent fw-bold" style="font-size: 0.85rem; color: #a14a1c; cursor: pointer;">
                  <iconify-icon icon="material-symbols:logout-rounded" class="fs-5" style="vertical-align: middle;"></iconify-icon>
                    خروج
                  </button>
                  </form>
                </div>
              </li>
             @endauth
               
              </li>
            </ul>

            <div class="d-none d-lg-flex align-items-end">
              <ul class="d-flex justify-content-end list-unstyled m-0">
          @auth
            <li>
            <a href="{{ route('client.register') }}" class="mx-3" style="text-decoration: none;">
               <iconify-icon icon="healthicons:person" class="fs-4 text-dark align-middle"></iconify-icon>
            </a>
            </li>
          @else
            <li>
            <a href="{{ route('client.register') }}" class="mx-3" style="text-decoration: none;">
               <iconify-icon icon="healthicons:person" class="fs-4 text-dark align-middle"></iconify-icon>
            </a>
            </li>
            @endauth

                @auth
                <li>
                    <a href="{{ route('client.likes.index') }}" class="mx-3 position-relative d-inline-block" style="text-decoration: none;">
                        <iconify-icon icon="mdi:heart" class="fs-4 text-dark align-middle"></iconify-icon>
                        
                        <span id="likes_count" class="position-absolute translate-middle rounded-circle d-flex align-items-center justify-content-center" 
                              style="top: 2px; start: 85%; width: 18px; height: 18px; background-color: #cbad41; color: white; font-size: 10px; font-weight: bold;">
                            {{ auth()->user()->likes()->count() }}
                        </span>
                    </a>
                </li>
                @endauth

                <li class="">
                  @php
                    
                    $cartDetails = \App\Models\CartItem::getCartDetails();
                  @endphp
                
                  <a href="#" class="mx-3 position-relative" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                    <iconify-icon icon="mdi:cart" class="fs-4"></iconify-icon>
                    
                    
                    <span class="cart-count-badge position-absolute translate-middle badge rounded-circle bg-primary pt-2">
                      {{ $cartDetails['total_count'] }}
                    </span>
                  </a>
                </li>


                 <!-- 📄 آیکون جدید و مینیمال صورت‌حساب/سفارشات -->
<a href="{{ url('/my-orders') }}" class="text-slate-700 hover:text-blue-600 transition-colors inline-block align-middle" title="سفارشات من">
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 24px; height: 24px; display: inline-block;">
      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
  </svg>
</a>


              </ul>

            </div>

          </div>

        </div>

      </nav>



    </div>
  </header>

  @yield('content')

  <footer id="footer" class="my-5">
    <div class="container py-5 my-5">
      <div class="row">

        <div class="col-md-3">
          <div class="footer-menu">
            <img src="/client/images/logo.png" alt="logo">
            <p class="blog-paragraph fs-6 mt-3">Subscribe to our newsletter to get updates about our grand offers.</p>
            <div class="social-links">
              <ul class="d-flex list-unstyled gap-2">
                <li class="social">
                  <a href="#">
                    <iconify-icon class="social-icon" icon="ri:facebook-fill"></iconify-icon>
                  </a>
                </li>
                <li class="social">
                  <a href="#">
                    <iconify-icon class="social-icon" icon="ri:twitter-fill"></iconify-icon>
                  </a>
                </li>
                <li class="social">
                  <a href="#">
                    <iconify-icon class="social-icon" icon="ri:pinterest-fill"></iconify-icon>
                  </a>
                </li>
                <li class="social">
                  <a href="#">
                    <iconify-icon class="social-icon" icon="ri:instagram-fill"></iconify-icon>
                  </a>
                </li>
                <li class="social">
                  <a href="#">
                    <iconify-icon class="social-icon" icon="ri:youtube-fill"></iconify-icon>
                  </a>
                </li>

              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="footer-menu">
            <h3>Quick Links</h3>
            <ul class="menu-list list-unstyled">
              <li class="menu-item">
                <a href="#" class="nav-link">Home</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link">About us</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link">Offer </a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link">Services</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link">Conatct Us</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-3">
          <div class="footer-menu">
            <h3>Help Center</h5>
              <ul class="menu-list list-unstyled">
                <li class="menu-item">
                  <a href="#" class="nav-link">FAQs</a>
                </li>
                <li class="menu-item">
                  <a href="#" class="nav-link">Payment</a>
                </li>
                <li class="menu-item">
                  <a href="#" class="nav-link">Returns & Refunds</a>
                </li>
                <li class="menu-item">
                  <a href="#" class="nav-link">Checkout</a>
                </li>
                <li class="menu-item">
                  <a href="#" class="nav-link">Delivery Information</a>
                </li>
              </ul>
          </div>
        </div>
        <div class="col-md-3">
          <div>
            <h3>Our Newsletter</h3>
            <p class="blog-paragraph fs-6">Subscribe to our newsletter to get updates about our grand offers.</p>
            <div class="search-bar border rounded-pill border-dark-subtle px-2">
              <form class="text-center d-flex align-items-center" action="" method="">
                <input type="text" class="form-control border-0 bg-transparent" placeholder="Enter your email here" />
                <iconify-icon class="send-icon" icon="tabler:location-filled"></iconify-icon>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </footer>

  <div id="footer-bottom">
    <div class="container">
      <hr class="m-0">
      <div class="row mt-3">
        <div class="col-md-6 copyright">
          <p class="secondary-font">© 2023 Waggy. All rights reserved.</p>
        </div>
        <div class="col-md-6 text-md-end">
          <p class="secondary-font">Free HTML Template by <a href="https://templatesjungle.com/" target="_blank"
              class="text-decoration-underline fw-bold text-black-50"> TemplatesJungle</a> Distributed by <a href="https://themewagon.com/" target="_blank"
              class="text-decoration-underline fw-bold text-black-50"> ThemeWagon</a></p>
        </div>
      </div>
    </div>
  </div>


  <script src="/client/js/jquery-1.11.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <script src="/client/js/plugins.js"></script>
  <script src="/client/js/script.js"></script>
  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <script>
    function like(productId){
      $.ajax({
        type: 'Post',
        url: '/likes/' + productId,
        data: {
          _token : "{{ csrf_token() }}"
        },

        success: function (data){
          var icon = $('#like-' + productId);
          icon.toggleClass('like');
          $('#like-count-' + productId).text(data.likes_count)
        },
        error: function(xhr){
          console.log(xhr.responseText);
        }
      });
    }
  </script>

<script>
  document.addEventListener('click', function (e) {
      const button = e.target.closest('.add-to-cart-btn');
      
      if (button) {
          e.preventDefault(); 
  
          const productId = button.getAttribute('data-id');
          const quantity = button.getAttribute('data-quantity') || 1;
          
          
          const selectedColorInput = document.querySelector('input[name="product_color"]:checked');
          const colorId = selectedColorInput ? selectedColorInput.value : null;
          
          console.log('اطلاعات ارسالی -> محصول:', productId, 'تعداد:', quantity, 'آیدی رنگ:', colorId); 
  
          button.style.pointerEvents = 'none';
          button.style.opacity = '0.5';
  
          //  ۲. آیدی رنگ را به ته آدرس URL اضافه می‌کنیم (یا بعداً در Body می‌فرستیم، اما چون آدرس روت شما /cart/add/{id} است، این بهترین راه‌حل است):
          fetch('/cart/add/' + productId, {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}' 
              },
              //  ۳. ارسال تعداد و آیدی رنگ به صورت هم‌زمان به لاراول
              body: JSON.stringify({ 
                  quantity: parseInt(quantity),
                  color_id: colorId // فرستادن رنگ به کنترلر
              })
          })
          .then(response => response.json())
          .then(data => {
              console.log('پاسخ سرور:', data);
              
              const badge = document.querySelector('.cart-count-badge');
              if (badge && data.total_count !== undefined) {
                  badge.textContent = data.total_count;
              }
  
              window.location.reload();
  
              button.style.pointerEvents = 'auto';
              button.style.opacity = '1';
          })
          .catch(error => {
              console.error('خطا در ارسال درخواست:', error);
              button.style.pointerEvents = 'auto';
              button.style.opacity = '1';
          });
      }
  });
  </script>

<script>
  document.addEventListener('click', function (e) {
      const removeButton = e.target.closest('.remove-from-cart-btn');
      
      if (removeButton) {
          e.preventDefault();
          
          if(confirm('آیا می‌خواهی این محصول را از سبد خریدت حذف کنی؟')) {
              const productId = removeButton.getAttribute('data-id');
              const colorId = removeButton.getAttribute('data-color-id'); // 👈 دریافت آیدی رنگ
  
              fetch('/cart/remove/' + productId, {
                  method: 'POST',
                  headers: {
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': '{{ csrf_token() }}'
                  },
                  body: JSON.stringify({
                      color_id: colorId //  فرستادن آیدی رنگ به کنترلر لاراول
                  })
              })
              .then(response => response.json())
              .then(data => {
                  window.location.reload();
              })
              .catch(error => {
                  console.error('خطا در حذف محصول:', error);
              });
          }
      }
  });
  </script>


<script src="{{ asset('client/js/plugins.js') }}"></script>
    <script src="{{ asset('client/js/script.js') }}"></script>

    <script>

$(document).ready(function() {
    // چک کردن اینکه آیا از قبل استانی در سشن انتخاب شده است یا خیر
    var savedProvinceId = $('#province-select').val();
    var savedCityId = '{{ session("selected_city_id") }}';

    // اگر استان از قبل انتخاب شده بود، شهرهایش را لود کن
    if (savedProvinceId) {
        // این همان تابعی است که با هم برای لود شهرها نوشتیم
        loadCitiesWithSelected(savedProvinceId, savedCityId);
    }
});

// نسخه هوشمندتر تابع لود شهرها که مقدار سشن را هم ست نگه می‌دارد
function loadCitiesWithSelected(provinceId, selectedCityId) {
    var citySelect = $('#city-select');
    if(provinceId) {
        $.ajax({
            url: '/get-cities/' + provinceId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                citySelect.html('<option value="">-- انتخاب شهر --</option>');
                var cities = Array.isArray(response) ? response : (response.cities || Object.values(response));
                
                $.each(cities, function(key, city) {
                    if(city && typeof city === 'object') {
                        // اگر آی‌دی شهر با آی‌دی سشن یکی بود، آن را selected کن
                        var isSelected = (city.id == selectedCityId) ? 'selected' : '';
                        citySelect.append('<option value="'+ city.id +'" '+ isSelected +'>'+ (city.name || city.title) +'</option>');
                    }
                });
                citySelect.removeAttr('disabled').prop('disabled', false);
            }
        });
    }
}

      // تنظیم هدر برای ارسال توکن CSRF در تمام درخواست‌های آژاکس
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
          }
      });
      
      // =========================================================================
      // ۱. توابع مربوط به بخش هدر صفحه (Header Dropdowns)
      // =========================================================================
      
      // تابع لود کردن شهرهای هدر بعد از انتخاب استان
      function loadCities(provinceId) {
          var citySelect = $('#city-select');
          if(provinceId) {
              citySelect.removeAttr('disabled').prop('disabled', false).html('<option value="">در حال لود...</option>');
              
              $.ajax({
                  url: '/get-cities/' + provinceId, // آدرس دقیق با پیشوند کلاینت
                  type: 'GET',
                  dataType: 'json',
                  success: function(response) {
                      citySelect.html('<option value="">-- انتخاب شهر --</option>');
                      var cities = Array.isArray(response) ? response : (response.cities || Object.values(response));
                      $.each(cities, function(key, city) {
                          if(city && typeof city === 'object') {
                              citySelect.append('<option value="'+ city.id +'">'+ (city.name || city.title) +'</option>');
                          }
                      });
                  },
                  error: function(xhr) {
                      console.log("خطا در لود شهرهای هدر:", xhr.responseText);
                  }
              });
          } else {
              citySelect.attr('disabled', 'disabled').prop('disabled', true).html('<option value="">-- انتخاب شهر --</option>');
          }
      }
      
      // تابع اعمال فیلتر هدر (تغییر دراپ‌دان شهر)
      function applyCityFilter(cityId) {
          var provinceId = $('#province-select').val();
          if (cityId) {
              saveCitySession(cityId, provinceId);
          }
      }
      
      
      // =========================================================================
      // ۲. توابع مربوط به داخل مدال (Modal Dropdowns)
      // =========================================================================
      
      // تابع لود کردن شهرهای داخل مدال بعد از انتخاب استان
      function loadModalCities(provinceId) {
          var modalCitySelect = $('#modal-city-select');
          var saveBtn = $('#btn-save-city');
          
          // ریست کردن دکمه تایید مدال
          saveBtn.attr('disabled', 'disabled').prop('disabled', true);
      
          if(provinceId) {
              modalCitySelect.removeAttr('disabled').prop('disabled', false).html('<option value="">در حال لود شهرها...</option>');
              
              $.ajax({
                  url: '/get-cities/' + provinceId, // آدرس دقیق با پیشوند کلاینت
                  type: 'GET',
                  dataType: 'json',
                  success: function(response) {
                      modalCitySelect.html('<option value="">-- انتخاب شهر --</option>');
                      var cities = Array.isArray(response) ? response : (response.cities || Object.values(response));
                      
                      $.each(cities, function(key, city) {
                          if(city && typeof city === 'object') {
                              modalCitySelect.append('<option value="'+ city.id +'">'+ (city.name || city.title) +'</option>');
                          }
                      });
                  },
                  error: function(xhr) {
                      console.log("خطا در لود شهرهای مدال:", xhr.responseText);
                  }
              });
          } else {
              modalCitySelect.attr('disabled', 'disabled').prop('disabled', true).html('<option value="">-- ابتدا استان را انتخاب کنید --</option>');
          }
      }
      
      // فعال کردن دکمه تایید مدال به محض اینکه کاربر یک شهر را انتخاب کرد
      function enableModalSaveBtn(cityId) {
          var saveBtn = $('#btn-save-city');
          if(cityId) {
              saveBtn.removeAttr('disabled').prop('disabled', false);
          } else {
              saveBtn.attr('disabled', 'disabled').prop('disabled', true);
          }
      }
      
      // کلیک روی دکمه تایید و اعمال فیلترِ داخل مدال
      function applyModalCityFilter() {
          var cityId = $('#modal-city-select').val();
          var provinceId = $('#modal-province-select').val();
          if(cityId && provinceId) {
              saveCitySession(cityId, provinceId);
          }
      }
      
      
      // =========================================================================
// ۳. تابع اصلی و مشترک ذخیره سشن و هدایت به صفحه اختصاصی شهر (Redirect)
// =========================================================================
function saveCitySession(cityId, provinceId) {
    $.ajax({
        url: '{{ route("client.setActiveCity") }}', // ارسال درخواست به متد ذخیره سشن
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            city_id: cityId,
            province_id: provinceId
        },
        success: function(response) {
            // اگر سشن با موفقیت ذخیره شد و اسلاگ شهر برگشت
            if(response.status === 'success' && response.slug) {
                // انتقال مستقیم کاربر به صفحه اختصاصی محصولات همان شهر (خارج از گروه)
                window.location.href = '/city/' + response.slug;
            } else {
                // در غیر این صورت فقط صفحه را رفرش کن
                location.reload();
            }
        },
        error: function(xhr) {
            console.log("خطا در ثبت و ذخیره فیلتر شهر:", xhr.responseText);
        }
    });
}
</script>

</body>
</html>
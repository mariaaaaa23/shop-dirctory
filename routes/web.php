<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\PictureController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductPictureController;
use App\Http\Controllers\Admin\ProductPropertyController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\PropertyGroupController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\FeaturedCategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductVariationController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\LoginController;
use App\Http\Controllers\Client\RegisterController;
use App\Http\Controllers\Client\CommentController as ClientCommentController;
use App\Http\Controllers\Client\ReportConroller as ClientReportController;
use App\Http\Controllers\Client\LikeController;
use App\Http\Controllers\Author\ProductController as AuthorProductController;
use App\Http\Controllers\Author\ProductPropertyController as AuthorProductPropertyController;
use App\Http\Controllers\Author\ProductVariationController as AuthorProductVariationController;
use App\Http\Controllers\Author\CommentController as AuthorCommentController;
use App\Http\Controllers\Author\DiscountController as AuthorDiscountController;
use App\Http\Controllers\Author\ProductGalleryController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\checkoutController;
use App\Http\Middleware\CheckPermission;
use App\Models\City;
use App\Models\Picture;
use App\Models\Product;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Routing\Annotation\Route as AnnotationRoute;

Route::prefix('')->name('client.')->group(function(){
    Route::get('/', [HomeController::class,'index'])->name('index');

    //Route::get('/login', [LoginController::class, 'create'])->name('login.create')->name('login');

    Route::get('/likes/',[LikeController::class, 'index'])->name('likes.index')->middleware('auth');
    //لایک کردن محصول
    Route::post('/likes/{product}/', [LikeController::class, 'store'])->name('like');
    Route::delete('/likes/{product}', [LikeController::class, 'destroy'])->name('likes.destroy');

    Route::get('/products/{id}', [ClientProductController::class, 'show'])->name('products.show');

    Route::post('/products/{product}/comments/store', [ClientCommentController::class, 'store'])->name('products.comments.store')->middleware('auth');

    Route::delete('/logout', [RegisterController::class, 'logout'])->name('logout');

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/login', [LoginController::class,'create'])->name('login');
    Route::post('/login', [LoginController::class,'store'])->name('login.store');

    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

    //صفحه اطلاعات گیرنده
    Route::get('/checkout', [checkoutController::class, 'index'])->name('checkout.index');
    //ارسال کاربر به درگاه بانکی
    Route::post('/checkout/payment', [checkoutController::class, 'processPayment'])->name('checkout.payment');
    Route::get('/checkout/verify/{order_id}', [checkoutController::class, 'verifyPayment'])->name('checkout.verify');
    

    //صفحه سفارشات
    Route::get('/my-orders', [checkoutController::class, 'myOrders'])->name('orders.index')->middleware('auth');

    //روت مربوط به اعمال تخفیف توسط کاربر
    Route::post('/coupons/apply', [CouponController::class,'applyCoupon'])->name('apply.coupon');

    //روت ارسال درخواست نویسندگی توسط کاربر
    Route::post('/request-author', [UserController::class, 'requestAuthor'])->name('request.author')->middleware('auth');

    

    //این مسیر برای اینکه هر دسته محصولات همونو نمایش بده
    Route::get('/shop/{type}/{id}', [ClientProductController::class, 'filterProducts'])->name('shop.filter');

    Route::post('/products/{id}/report', [ClientReportController::class, 'storeReport'])->name('products.report')->middleware('auth');
});



Route::prefix('/adminpanel')->name('admin.')->middleware(CheckPermission::class . ':view-dashboard')->group(function(){

    Route::get('/', function(){
        return view('admin.home');
    });

    Route::resource('/categories', CategoryController::class);

    Route::resource('/cities', CityController::class);


    Route::resource('/roles', RoleController::class);

    Route::resource('/users', UserController::class);

    Route::resource('/brands', BrandController::class);

    Route::resource('/sliders', SliderController::class);

    Route::resource('/products', ProductController::class);

    //نمایش روت آگهی های منتظر تائید
    Route::get('/product-reviews', [ProductController::class, 'reviewInput'])->name('products.reviews');
    //روت تغغیر وضعیت
    Route::put('/products/{product}/change-status', [ProductController::class, 'changeStatus'])->name('products.changeStatus');


    Route::resource('products.pictures', PictureController::class);


    Route::get('/products/{product}/properies',[ProductPropertyController::class,'index'])->name('product_property.index');
    Route::get('/products/{product}/properties',[ProductPropertyController::class,'create'])->name('product_property.create');
    Route::post('/products/{product}/properties',[ProductPropertyController::class,'store'])->name('product_property.store');


    Route::get('/products/{product}/variations', [ProductVariationController::class, 'index'])->name('products.variations.index');
    Route::get('/products/{product}/variations/create', [ProductVariationController::class, 'create'])->name('products.variations.create');
    Route::post('/products/{product}/variations', [ProductVariationController::class, 'store'])->name('products.variations.store');
    Route::delete('/variations/{variation}', [ProductVariationController::class, 'destroy'])->name('products.variations.destroy');


    Route::resource('products.discounts', DiscountController::class);

    //روت دیدن آگهی های نویسنده
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::patch('/reports/{id}/seen', [ReportController::class, 'markAsSeen'])->name('reports.seen');
    //روت حذف آگهی کاربر
    Route::delete('/products/{id}', [ReportController::class, 'destroyPost'])->name('products.destroy');
    //روت دکمه مسدود کردن کاربر
    Route::patch('/users/{id}/block', [ReportController::class, 'blockUser'])->name('users.block');



    Route::resource('property_groups', PropertyGroupController::class);

    Route::get('/products/{product}/comments', [AdminCommentController::class, 'index'])->name('product.comments.index');
    Route::delete('/products/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');

    Route::resource('properties', PropertyController::class);

    Route::get('/featuredCategory', [FeaturedCategoryController::class,'create'])->name('featuredCategory.create');
    Route::post('/featuredCategory', [FeaturedCategoryController::class,'store'])->name('featuredCategory.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    //برای وضعیت سفارش
    Route::put('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
    Route::post('/coupons/store', [CouponController::class, 'storeCoupon'])->name('coupons.store');

});

Route::middleware([CheckPermission::class])->prefix('author')->name('author.')->group(function(){

    Route::resource('products', AuthorProductController::class);

    Route::resource('products.gallery', ProductGalleryController::class)->only(['index','store','destroy']);

    Route::resource('products.properties', AuthorProductPropertyController::class)->only(['index','store']);

    Route::resource('products.variations', AuthorProductVariationController::class)->only(['index','store']);
    Route::delete('/variations/{variation}', [AuthorProductVariationController::class, 'destroy'])->name('variations.destroy');

    Route::get('/comments', [AuthorCommentController::class, 'index'])->name('comments.index');
    Route::delete('/comments/{comment}', [AuthorCommentController::class, 'destroy'])->name('comments.destroy');

    Route::resource('products.discounts', AuthorDiscountController::class)->only(['create','store','destroy']);


    
    //روت ذخیره استان و شهر انتخاب شده در سشن
    Route::post('/set-active-city', [HomeController::class, 'setActiveCity'])->name('setActiveCity');

});


//گرفتن شهرهایی که مربوط به این استان هستند
Route::get('/api/states/{state_id}/cities', function($state_id) {
    return City::where('state_id', $state_id)->get(['id', 'name']);
});

//روت اختصاصس برای نمایش محصولات بر اساس اسلاگ شهر
Route::get('/city/{slug}', [HomeController::class, 'cityProducts'])->name('city.products');

Route::get('/get-cities/{province_id}', [HomeController::class, 'getCities'])->name('getCities');



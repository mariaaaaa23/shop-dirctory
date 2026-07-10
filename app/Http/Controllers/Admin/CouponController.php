<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CouponController extends Controller
{

  public static function middleware()
    {
        return[
            new Middleware('permission:manage coupons', only:['index','create','store','edit','update']),
        ];
    }

    public function index()
    {
        //دریافت تمام تخفیف ها به ترتیب جدیدترین ها
        $coupons = Coupon::latest()->get();

        return view('admin.coupons.index', compact('coupons'));
    }
    public function storeCoupon(CouponRequest $request)
    {
        Coupon::create([
            'code' => strtoupper($request->code),
            'percent' => $request->percent,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->back()->with('success', 'کد نخفیف با موفقیت ساخته شد');
    }


    //این تابع کد تخفیف وارد شده توسط کاربر رو بررسی میکنه
  public function applyCoupon(Request $request)
  {
    $request->validate([
        'coupon_code' => 'required',
    ]);

    //پیدا کردن کد تخفیف در دیتابیس
    $coupon = Coupon::where('code', $request->coupon_code)->first();

    //بررسی اینه کد تخفیف وجود داره یا نه و اعتبار کد تخفیف
  if(!$coupon || !$coupon->isValid()){
    return redirect()->back()->with('error', 'کد تخفیف منقضی شده');
  }

  //محاسه تخفیف روی مبلغ کل سبد خرید
  $totalAmount = session()->get('total_amount');
  $discoundAmount = ($totalAmount * $coupon->percent) / 100;
  $finalAmount = $totalAmount - $discoundAmount;

  //ذخیره اطلاعات تخفیف در سشن برای استفاده در مرحله پرداخت بانکی
  session()->put('coupon', [
    'code' => $coupon->code,
    'percent' => $coupon->percent,
    'discound_amount' => $discoundAmount,
    'final_amount' => $finalAmount
  ]);

  return redirect()->back()->with('success', 'کد تخفیف با موفقیت اعمال شد');

  }
}

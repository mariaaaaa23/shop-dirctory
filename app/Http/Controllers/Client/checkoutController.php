<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Shetabit\Multipay\Invoice;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use App\Models\Coupon;
use App\Models\ProductVariation;
use Shetabit\Multipay\Payment as MultipayPayment;
use Shetabit\Shoping\Facades\Payment; 
use Shetabit\Multipay\Drivers\Zarinpal\Zarinpal;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class checkoutController extends Controller
{
    public static function middleware()
    {
        return[
            new Middleware('permission:manage own cartItems', only:['index']),
        ];
    }
    public function index()
    {
        //گرفتن آیتم های سبد خرید کاربر لاگین شده به همراه اطلاعات محصول
        $cartItems = CartItem::where('user_id', auth()->id())->with('product')->get();

        if($cartItems->isEmpty()){
            return redirect()->route('/')->with('error', 'سبد خرید شما خالی است');
        }

        //محاسبه جمع کل فاکتور
        $totalAmount = $cartItems->sum(function($item){
            $price = $item->product->has_discount ? $item->product->with_discount : $item->product->cost;
            return $price * $item->quantity;
        });

        return view('client.checkout.index', compact('cartItems','totalAmount'));
    }

    public function processPayment(Request $request)
    {
        $cartItems = CartItem::where('user_id', auth()->id())->get();
        if($cartItems->isEmpty()){
            return redirect()->route('/')->with('error', 'سبد شما خالی است');
        }
    
        // ۱. محاسبه قیمت کل اولیه از روی سبد خرید (مبلغ اصلی)
        $totalAmount = $cartItems->sum(function($item){
            $price = $item->product->has_discount ? $item->product->with_discount : $item->product->cost;
            return $price * $item->quantity;
        });
    
        // مقادیر اولیه برای تخفیف
        $discountAmount = 0;
        $couponId = null;
    
        // ۲. بررسی و اعمال کد تخفیف
        if ($request->filled('coupon_code')) {
            // پیدا کردن کد تخفیف در دیتابیس
            $coupon = \App\Models\Coupon::where('code', strtoupper($request->coupon_code))->first();
    
            // اگر کاربر کدی نوشته بود ولی معتبر یا فعال نبود، برمی‌گردد و خطا می‌دهد
            if (!$coupon || !$coupon->isValid()) {
                return redirect()->back()->with('error', 'کد تخفیف وارد شده معتبر نیست ! ');
            }

            //بررسی اینکه آیا این شماره تلفن قبلا با این کد تخفیف خرید م.فق داشته یانه 
            $alreadyUsed = Order::where('phone', $request->input('phone'))->where('coupon_id', $coupon->id)->exists();

            if($alreadyUsed){
                return redirect()->back()->with('error', 'شما قبلا از این کد تخفیف استفاده کرده اید');
            }
    
            // محاسبه مبلغ تخفیف
            $discountAmount = ($totalAmount * $coupon->percent) / 100;
            $couponId = $coupon->id;
    
            // ذخیره درصد تخفیف در سشن
            session()->put('applied_coupon_percent', $coupon->percent);
        }
    
        // ۳. محاسبه مبلغ نهایی پرداخت
        $finalAmount = $totalAmount - $discountAmount;
    
        // ۴. ثبت سفارش در دیتابیس با اطلاعات دقیق تخفیف
        $order = Order::create([
            'user_id' => auth()->id(),
            'address' => $request->address,
            'phone' => $request->phone,
            'total_amount' => $totalAmount,       // مبلغ اصلی و بدون تخفیف فاکتور
            'coupon_id' => $couponId,             // شناسه کد تخفیف (اگر اعمال شده باشد)
            'discount_amount' => $discountAmount, // مبلغی که کسر شده است
            'final_amount' => $finalAmount,       // مبلغ نهایی و خالص پرداختی
            'status' => 'pending',
        ]);
    
        // ۵. ارسال قیمت نهایی (تخفیف خورده) به درگاه پرداخت
        $invoice = (new Invoice)->amount((int)$finalAmount); // حتماً باید $finalAmount به بانک ارسال شود
    
        $payment = \Payment::via('local')
        ->callbackUrl(route('client.checkout.verify', ['order_id' => $order->id]))
        ->purchase($invoice, function($driver, $transactionId) use ($order) {
            $order->update(['authority' => $transactionId]);
        })->pay();
    
        // گرفتن مستقیم پارامترهای فرم تستی برای ریدایرکت خودکار به verify
        $inputs = $payment->getInputs();
    
        if (isset($inputs['successUrl'])) {
            return redirect($inputs['successUrl']);
        }
    
        return $payment;
    }

   
public function verifyPayment(Request $request, $order_id)
{
    $order = Order::findOrFail($order_id);

    try {
        $receipt = \Payment::via('local')->amount((int)$order->total_amount)->verify();

        $order->update([
            'status'        => 'paid',
            'tracking_code' => $receipt->getReferenceId()
        ]);

        $cartItems = CartItem::where('user_id', auth()->id())->get();

        foreach($cartItems as $item){

            if($item->color_id){

                //پیدا کردن سطر مربوط به تنوع محصول بر اساس آیدی محصول و آیدی رنگ
                $variation = ProductVariation::find($item->color_id);
                
                if($variation){

                    //کسر از موجودی رنگ مورد نظر
                    $variation->stock = max(0, $variation->stock - $item->quantity);
                    $variation->save();
                }
            }else{
                //گرنه اگر محصول ساده بود و رنگ مداشت از موجودی کل محصول کم بشه
                $product = $item->product;
                if($product && isset($product->stock)){
                    $product->stock = max(0, $product->stock - $item->quantity);
                    $product->save();
                }
            }
        }

        // پاک کردن آیتم‌های سبد خرید کاربر
        CartItem::where('user_id', auth()->id())->delete();

        //  به جای متن، صفحه ویو موفقیت را لود می‌کنیم و متغیرها را می‌فرستیم
        return view('client.checkout.verify', [
            'status' => 'success',
            'tracking_code' => $receipt->getReferenceId(),
            'amount' => $order->total_amount,
            'order_id' => $order->id
        ]);

    } catch (InvalidPaymentException $exception) {
        $order->update(['status' => 'failed']);

        // 👈 لود همان صفحه با وضعیت خطا
        return view('client.checkout.verify', [
            'status' => 'failed',
            'message' => $exception->getMessage(),
            'amount' => $order->total_amount
        ]);
    }
}


    public function myOrders()
    {
        //گرفتن تمام سفارشات کاربر لاگین شده
        $orders = Order::where('user_id', auth()->id())->latest()->get();

        return view('client.checkout.orders', compact('orders'));
    }

}

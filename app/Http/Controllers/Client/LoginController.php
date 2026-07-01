<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\LoginRequest;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LoginController extends Controller
{
    public static function middleware()
    {
        return[
            new Middleware('permission:login users', only:['create','store']),
            new Middleware('permission:logout users', only:['logout'])
        ];
    }
    public function create()
    {
        return view('client.login.create');
    }

    public function store(LoginRequest $request)
    {
        // داده های تایید شده رو میگیریم یعنی از قبل در دیتابیس ذخیره شده
        $credentials = $request->only('phone','password');

        // تلاش برای ورود
        // فیلد remember برای این است که کاربر لاگین بماند
        if(Auth::attempt($credentials, $request->has('remember'))){
            // session()->regenerate() برای امنیت هست مثل این میمونه که وقتی وارد خونه شدی کلید قفل رو عوض کنی تا کسی نتونه از روی کلید قبلی تو کپی داشته باشه
            $request->session()->regenerate();
            
            // ​redirect()->intended('/'): یعنی کاربر را بفرست به همان جایی که می‌خواست برود. مثلاً اگر کاربر می‌خواست به سبد خرید برود ولی سایت او را به لاگین فرستاده بود، بعد از لاگین لاراول او را مستقیم می‌برد به سبد خرید
            return redirect()->intended('/')->with('success', 'خوش آمدید');
        }
        return back()->withErrors(['phone', 'شماره موبایل یا رمز عبور اشتباه است'])->onlyInput('phone');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return require('/');
    }



    //این تابع برای اینکه وقتی کاربر لاگین کرد اگه محصولی ااز قبل از سشن داشت سریعا به دیتابیس منتقل بشه
    protected function authenticated(Request $request, $user)
    {
        $cart = session()->get('cart');

        if($cart){
            foreach ($cart as $productId => $details){

                //چک کردن اینکه آیا این محصول از قبل تو دیتابیس این کاربر هست یا نه
                $cartItem = CartItem::where('user_id', $user->id)->where('product_id', $productId)->first();

                if($cartItem){
                    $cartItem->increment('quantity', $details['quantity']);
                }else{
                    CartItem::create([
                        'user_id' => $user->id,
                        'product_id' => $productId,
                        'quantity' => $details['quantity']
                    ]);
                }
            }

            //پاک کردن سبد خرید از سشن بعد از انتقال به سشن
            session()->forget('cart');
        }

        return redirect()->route('/');
    }
}

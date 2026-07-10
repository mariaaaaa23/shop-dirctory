<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CartController extends Controller
{
    public static function middleware()
    {
        return[
            new Middleware('permission:manage own cartItems', only:['store','destroy']),
        ];
    }
    public function add(Request $request, $productId)
{
    $product = Product::findOrFail($productId);
    $quantity = $request->input('quantity', 1);
    $colorId = $request->input('color_id'); // دریافت آیدی رنگ ارسالی

    $totalCount = 0;
    
    if (auth()->check()) {

        // بخش اول: کاربر لاگین کرده است -> ذخیره در دیتابیس
        $cartItem = CartItem::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->where('color_id', $colorId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            // ساخت ردیف جدید در دیتابیس سبد خرید با آیدی رنگ
            CartItem::create([
                'user_id'    => auth()->id(),
                'product_id' => $productId,
                'color_id'   => $colorId,
                'quantity'   => $quantity
            ]);
        }

        // محاسبه تعداد کل آیتم‌های دیتابیس برای کاربر لاگین‌شده
        $totalCount = CartItem::where('user_id', auth()->id())->sum('quantity');

    } else {

        // بخش دوم: کاربر مهمان است -> ذخیره در سشن
        $colorName = null;
        
        // پیدا کردن نام واقعی رنگ برای سشن
        if ($colorId) {
            $variation = ProductVariation::find($colorId);
            if ($variation) {
                $colorName = $variation->color_name;
            }
        }

        $cart = session()->get('cart', []);
        
        // ایجاد کلید ترکیبی هوشمند برای تفکیک ردیف‌ها در سشن
        $cartKey = $colorId ? $productId . '_' . $colorId : $productId;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $price = $product->has_discount ? $product->with_discount : $product->cost;
            
            $cart[$cartKey] = [
                'name'       => $product->name,
                'quantity'   => $quantity,
                'price'      => $price,
                'image'      => $product->image,
                'color_name' => $colorName,
            ];
        }

        session()->put('cart', $cart);

        // محاسبه تعداد کل آیتم‌های داخل سشن برای کاربر مهمان
        $totalCount = collect($cart)->sum('quantity');
    }

    return response()->json([
        'message'     => 'محصول با موفقیت به سبد خرید اضافه شد.',
        'total_count' => $totalCount
    ]);
}

  public function remove(Request $request, $productId)
  {
    if(auth()->check()){
        //حذف از دیتابیس
        CartItem::where('user_id', auth()->id())->where('product_id', $productId)->delete();
    }else{
        //حذف از سشن
        $cart = session()->get('cart', []);
        if(isset($cart[$productId])){
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
    }
    return response()->json(['message' => 'محصول از سبد خرید حذف شد']);
  }

}


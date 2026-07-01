<?php

namespace App\Models;

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'color_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getCartDetails()
    {
        $totalPrice = 0;
        $formattedItems = [];

        //دریافت از دیتابیس برای کاربر لاگین شده
        if(auth()->check()){
            $items = self::where('user_id', auth()->id())->with('product', 'color')->get();
            $totalCount = $items->sum('quantity');

            foreach($items as $item){
                if(!$item->product) continue;

                $price = $item->product->has_discount ? $item->product->with_discount : $item->product->cost;
                $subTotal = $price * $item->quantity;
                $totalPrice += $subTotal;

                $formattedItems[] = [
                    'id' => $item->product_id,
                    'name' => $item->product->name,
                    'price' => $price,
                    'image' => $item->product->image,
                    'quantity' => $item->quantity,
                    'sub_total' => $subTotal,
                    'color_name' => $item->color ? $item->color->color_name : null,
                ];
            }
        }else{
            //دریافت از سشن برای کاربر مهمان
            $sessionCart = session()->get('cart', []);
            $totalCount = collect($sessionCart)->sum('quantity');

            foreach($sessionCart as $id => $item){
                $subTotal = $item['price'] * $item['quantity'];
                $totalPrice += $subTotal;

                $formattedItems[] = [
                    'id' => $id,
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'image' => $item['image'],
                    'quantity' => $item['quantity'],
                    'sub_total' => $subTotal,
                    'color_name' => isset($item['color_name']) ? $item['color_name'] : null,
                ];
            }
        }

        return [
            'items' => $formattedItems,
            'total_count' => $totalCount,
            'total_price' => $totalPrice
        ];
    }

    //تابع سفارش رنگ لباس
    public function color()
   {
    return $this->belongsTo(ProductVariation::class, 'color_id');  
   }
   
}

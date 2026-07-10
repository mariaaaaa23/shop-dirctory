<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DiscountRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DiscountController extends Controller
{
    public static function middleware(): array
    {
            return[
                new Middleware('permission:manage own discounts', only:['create','store','destroy'])
            ];
    }

    public function create(Product $product)
    {
        if($product->user_id !== auth()->id()){
            abort(403, 'شما اجازه دسترسی به این محصول را ندارید');
        }

        return view('author.discounts.create', compact('product'));
    }

    public function store(DiscountRequest $request, Product $product)
    {
        if($product->user_id !== auth()->id()){
            abort(403);
        }

        $product->addDiscount($request->value);

        return redirect()->route('author.products.index')->with('success', 'تخفیف با موفقیت اعمال شد');
    }

    public function destroy(Product $product)
    {
        if($product->user_id !== auth()->id()){
            abort(403);
        }

        $product->deleteDiscount();

        return back()->with('success', 'تخفیف محصول با موفقیت حذف شد');
    }
}

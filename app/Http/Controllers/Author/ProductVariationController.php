<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductVariationRequest;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductVariationController extends Controller
{
    public static function middleware()
    {
        return[
            new Middleware('permission:manage own productVariations', only:['index','store','destroy']),
        ];
    }
    public function index(Product $product)
    {
        if($product->user_id !== auth()->id()){
            abort(403, 'شما اجازه دسترسی به تنوع های این محصول را ندارید');
        }

        $product->load('variations');

        return view('author.products.variations', compact('product'));
    }

    public function store(ProductVariationRequest $request, Product $product)
    {
        if($product->user_id !== auth()->id()){
            abort(403);
        }

        $imagePath = null;
        if($request->hasFile('image')){
            $imagePath = $request->file('image')->store('client/images', 'public');
        }

        $product->variations()->create([
            'color_name' => $request->color_name,
            'color_code' => $request->color_code,
            'price' => $request->price,
            'image' => $imagePath,
            'stock' => $request->stock
        ]);
        return redirect()->back()->with('success', 'تنوع جدید با موفقیت به آگهی شما اضافه شد');
    }

    public function destroy(ProductVariation $variation, Product $product)
    {
        if($product->user_id !== auth()->id()){
            abort(403);
        }

        //پاک کردن فایل تصویر
        if($variation->image){
            Storage::disk('public')->delete($variation->image);
        }

        $variation->delete();

        return redirect()->back()->with('success', 'تنوع مورد نظر با موفقیت حذف شد');
    }
}

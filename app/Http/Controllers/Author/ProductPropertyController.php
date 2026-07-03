<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductPropertyController extends Controller
{
    public function index(Product $product)
    {
        if($product->user_id !== auth()->id()){
            abort(403, 'شما اجازه دسترسی به مشخصات این محصول را ندارید');
        }

        $product->load('properties');
        $product->load('category.propertyGroups');
        
        $propertyGroups = $product->category ? $product->category->propertyGroups : collect();

        // اصلاح شد: به پوشه product_property و فایل index اشاره می‌کند
        return view('author.product_property.index', [
            'product' => $product,
            'propertyGroups' => $propertyGroups
        ]);
    }

    public function store(Request $request, Product $product)
    {
        if($product->user_id !== auth()->id()){
            abort(403);
        }

        $properties = collect($request->get('properties'))->filter(function ($item) {
            if(!empty($item['value'])){
                return $item;
            }
        });

        $product->properties()->sync($properties);

        return redirect()->route('author.products.index')->with('success', 'مشخصات آگهی با موفقیت ذخیره شد');
    }
}
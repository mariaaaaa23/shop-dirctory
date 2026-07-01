<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends Controller
{
    public static function middleware()
    {
        return[
            new Middleware('permission:view posts', only:['show'])
        ];
    }
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return view('client.products.show', 
            compact('product')
        );
    }

    //این تابع برای اینکه محصولات همون دسته رو نمایش بده
    public function filterProducts($type, $id)
    {
        $title = "";
        $products = collect();

        if($type ==='brand'){
            $brand = Brand::findOrFail($id);
            $title = $brand->name . " برند ";
            $products = $brand->products()->paginate(12);
        }elseif($type == 'category'){
            $category = Category::findOrFail($id);
            $title = " دسته بندی: " . $category->title;
            $products = $category->products()->paginate(12);
        }

        return view('client.products.index', compact('title','products'));
    }
}

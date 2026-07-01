<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
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
}

<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;


class LikeController extends Controller
{
    public function index()
    {
        if(!auth()->check()){
            return redirect()->route('client.register');
        }

        $products = auth()->user()->likes;
        return view('client.likes.index', 
            compact('products')
        );
    }
    public function store(Request $request, Product $product)
    {
       $user = auth()->user();

       $user->like($product);

        return response()->json(['status' => 'success', 'likes_count' => $user->likes()->count()]);
    }

    public function destroy(Product $product)
    {
        auth()->user()->likes()->detach($product->id);

        return back();
    }
}

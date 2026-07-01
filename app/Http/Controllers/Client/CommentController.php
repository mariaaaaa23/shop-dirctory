<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CommentRequest;
use App\Models\Product;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CommentController extends Controller
{
    public static function middleware()
    {
        return[
            new Middleware('permission:create comments', only:['store'])
        ];
    }
    public function store(CommentRequest $request, Product $product)
    {
        Comment::query()->create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'text' => $request->get('text')
        ]);

        return redirect()->route('client.products.show', $product->id)->with('success', 'نظر شما با موفقیت ثبت شد');
    }
}

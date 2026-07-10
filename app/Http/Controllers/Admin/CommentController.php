<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CommentController extends Controller
{
    public static function middleware()
    {
        return[
            new Middleware('permission:view comments', only:['index']),
            new Middleware('permission:manage own comments', only:['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index($productId)
    {
        // پیداکردن محصول مورد نظر براساس آیدی
        $product = Product::findOrFail($productId);

        // گرفتن تمام کامنت های مربوط به این محصول همراه با اطلاعات کاربر ارسال کننده
        $comments = Comment::where('product_id', $productId)->with('user')->latest()->paginate(10);
        
        return view('admin.product_comments.index',
            compact('comments','product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('admin.product.comments.index')->with('success', 'کامنت با موفقیت حذف شد');
    }
}

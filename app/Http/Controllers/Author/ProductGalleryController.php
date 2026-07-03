<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Picture;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductGalleryController extends Controller
{
    public function index(Product $product)
    {
        //چون نویسنده فقط باید محصولات خودش رو مدیریت کنه پس باید شرط بزاریم
        //اگر محصول متعلق به این کاربر نبود خطا بده
        if($product->user_id !== auth()->id()){
            abort(403, 'شما اجازه دسترسی به گالری این محصول را ندارید');
        }

        return view('author.pictures.index', [
            'product' => $product
        ]);
    }

    public function store(Request $request, Product $product)
    {
        if($product->user_id !== auth()->id()){
            abort(403);
        }

        $product->addPicture($request);

        return redirect()->back()->with('success', 'گالری آگهی شما با موفقیت ایجاد شد');
    }

    public function destroy(Product $product, Picture $picture)
    {
        if($product->user_id !== auth()->id()){
            abort(403);
        }

        $product->deletePicture($picture);

        return redirect()->back()->with('success', 'گالری آگهی شما با موفقیت حذف شد');
    }
}

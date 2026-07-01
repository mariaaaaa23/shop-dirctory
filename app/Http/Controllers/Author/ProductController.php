<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewProductRequest;
use App\Http\Requests\Admin\ProductUpdateRequst;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\State;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id', auth()->id())
        ->with(['category', 'city.state'])
        ->latest()
        ->get();

        return view('author.products.index', compact('products'));
    }

    public function create()
    {
        $provinces = State::all();
        $categories = Category::all();
        $brands = Brand::all();

        return view('author.products.create',
            compact('categories','brands','provinces'));
    }

    public function store(NewProductRequest $request)
    {
        $data = $request->validated();

        $data['cost'] = $request->cost;
        

        if($request->hasFile('image')){
           $data['image'] = $request->file('image')->store('products', 'public');
        }

       
        $data['user_id'] = auth()->user()->id; 
        //نویسنده باید منتظر تایید ادمین باشه
        $data['status'] = 'pending';

    
        Product::create($data);

        return redirect()->route('author.products.index')->with('success', 'آگهی شما با موفقیت ایجاد شد');
    }
    public function edit(Product $product)
    {
        if(auth()->user()->id !== $product->user_id){
            abort(403, 'شما اجازه ویرایش این آگهی را ندارید');
        }

        $provinces = State::all();
        $categories = Category::all();
        $brands = Brand::all();

        return view('author.products.edit', compact('product','categories','brands','provinces'));
    }

    public function update(ProductUpdateRequst $request, Product $product)
    {
       
    if (auth()->user()->id !== $product->user_id) {
        abort(403, 'شما اجازه ویرایش این آگهی را ندارید');
    }

    $data = $request->validated();
    $data['cost'] = $request->cost;

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('products', 'public');
    }

    //  وقتی آگهی رد شده ویرایش می‌شود، وضعیت باید مجدداً به pending تغییر کند تا برود برای بررسی ادمین:
    $data['status'] = 'pending'; 

    
    $product->update($data);

    return redirect()->route('author.products.index')->with('success', 'آگهی شما با موفقیت بروزرسانی شد و به صف تایید رفت.');
    }

    public function destroy(Product $product)
    {
        if(auth()->user()->id !== $product->user_id){
            abort(403, 'شما اجازه حذف این آگهی را ندارید');
        }

        $product->delete();

        return redirect()->route('author.products.index')->with('success', 'آگهی شما با موفقیت حذف شد');
    }
}

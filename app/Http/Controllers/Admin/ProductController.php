<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewProductRequest;
use App\Http\Requests\Admin\ProductUpdateRequst;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\State;
use App\Models\PropertyGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductController extends Controller
{

    public static function middleware()
    {
        return[
            new Middleware('permission:manage posts', only:['index','create','store','edit','update','destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('user_id', auth()->user()->id)->paginate(10);
        return view('admin.products.index',
           compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = State::all();
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.create',
            compact('categories','brands','provinces'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewProductRequest $request)
    {
        // گرفتن داده های تایید شده
        $data = $request->validated();

        // مدیریت آپلود عکس
        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('products','public');
        }

        $data['user_id'] = auth()->user()->id;
        //آگهی ادمین نیازی به تایید نداره
        $data['status'] = 'approved';

        // ذخیره در دیتابیس
         Product::create($data);


        return redirect()->route('admin.products.index')->with('success', 'محصول با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        if($product->user_id !== auth()->user()->id){
            abort(403, 'شما اجزه ویرایش محصولات نویسندگان را ندارید');
        }
        $provinces = State::all();
        $categories = Category::all();
        $brands = Brand::all();


        return view('admin.products.edit',
            compact('product','categories','brands','provinces'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequst $request, Product $product)
    {
        // گرفتن داده های تایید شده
        $date = $request->validated();

        // مدیریت عکس جدبد
        if($request->hasFile('image')){
            // ذخیره عکس جدید و اضافه کردن مسیر به آرایه data
        $date['image'] = $request->file('image')->store('products','public');
        }

        $date['status'] = $request->input('status', $product->status);

        // آپدیت محصول با داده های جدید
        $product->update($date);



        return redirect()->route('admin.products.index')->with('success', 'محصول با موفقیت بروزرسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //حذف فایل تصویر از حافظه
        if($product->image){
            // چک میکنیم که فایل واقعا وجود دارد بعد حذف میکنیم
            if(Storage::disk('public')->exists($product->image)){
                Storage::disk('public')->delete($product->image);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'محصول با موفقیت حذف شد');
    }


    //تابع نمایش لیست آگخی که وضعیت آن ها pending هست
    public function reviewInput()
    {
        $products = Product::where('status', 'pending')->latest()->get();

        return view('admin.products.reviews',compact('products'));
    }

    //تابع سریع برای تایید یا رد کردن آگهی بدون دستکاری فیلد ها
    public function changeStatus(Request $request, Product $product)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected' // آرایه ولیدیشن اصلاح شد
        ]);

        $product->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.products.reviews')->with('success', 'وضعیت آگهی با موفقیت ثبت شد');
    }

}

<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\featuredCategory;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\State;
use Shetabit\Multipay\Request as MultipayRequest;

class HomeController extends Controller
{
    public function index()
    {
        $category = Category::first();
        $sliders = Slider::all();
        $provinces = State::all();

        //ساخت کوئری پایه ای برای آگهی
        $productsQuery = Product::where('status', 'approved')->latest();

        // اگر کاربر شهری رو انتخاب کرده بود فیلتر شهر رو اضافه کن
        if(session()->has('selected_city_id')){
            $productsQuery->where('city_id', session('selected_city_id'));
        }
        
        
        $products = $productsQuery->get();
        //dd($products->pluck('status', 'name')->toArray());
        $featuredCategory = featuredCategory::first();
        $featuredCategoryProducts = $featuredCategory ? Product::where('category_id', $featuredCategory->category_id)
        ->get() : collect();
        

        return view('client.home',
            compact('category','sliders','featuredCategoryProducts','products','productsQuery','provinces'));
    }

    public function getCities($province_id)
    {
        $cities = city::where('state_id', $province_id)->get();
        return response()->json($cities);
    }

    public function setActiveCity(Request $request)
    {
        //اگر کاربر فیلتر را پاک کرد
        if(!$request->city_id){
            session()->forget(['selected_city_id', 'selected_province_id']);
            return response()->json(['status' => 'success']);
        }


        //ذخیره همزمان شهر و استان در سشن
        session([
            'selected_city_id' => $request->city_id,
            'selected_province_id' => $request->province_id
        ]);

        //پیدا کردن اسلاگ شهر برای هدایت در جاوا اسکریپت
        $city = City::find($request->city_id);

        return response()->json([
            'status' => 'success',
            'slug' => $city ? $city->slug : null
        ]);
    }

    public function cityProducts($slug)
    {
        //پیدا کردن شهر بر اساس اسلاگ
        $city = City::where('slug', $slug)->firstOrFail();

        //پیدا کردن تمام محصولات تایید شده ای کخ بر اساس این شهر هستند
        $products = Product::where('city_id', $city->id)->where('status' , 'approved')->latest()->paginate(12);

        return view('client.products.city_products', compact('city','products'));
    }
}
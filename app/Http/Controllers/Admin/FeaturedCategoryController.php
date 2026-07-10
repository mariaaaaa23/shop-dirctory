<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FeaturedCategoryRequest;
use App\Models\Category;
use App\Models\FeaturedCategory;
use App\Models\featuredCategory as ModelsFeaturedCategory;
use App\Models\PropertyGroup;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class FeaturedCategoryController extends Controller
{
    public static function middleware()
    {
        return[
            new Middleware('permission:manage featuredCategories', only:['create']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.featuredCategory.create',[
            'featuredCategory' => featuredCategory::query()->first(),
            'categories' => Category::query()->where('category_id', null)->get(),
            'properties'=>PropertyGroup::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FeaturedCategoryRequest $request)
    {
        featuredCategory::query()->delete();

        $featuredCategory = featuredCategory::query()->create([
            'category_id' => $request->get('category_id')
        ]);

        // هر گروه ویژگی که برای دسته بندی تیک زدیم ذخیره میکنه در دیتابیس
        $featuredCategory->propertyGroups()->attach($request->get('properties'));



        return redirect()->route('admin.featuredCategory.create')->with('success', 'دسته بندی های ویژه با موفقیت ایجاد شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(FeaturedCategory $featuredCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeaturedCategory $featuredCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FeaturedCategory $featuredCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeaturedCategory $featuredCategory)
    {
        //
    }
}

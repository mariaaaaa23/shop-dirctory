<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Models\PropertyGroup;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public static function middleware(): array
    {
        return[
            new Middleware('permission:manage categories', only:['index','create','store','edit','update','destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.categories.index',[
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create', [
            'categories'=>Category::all(),
            'properties' => PropertyGroup::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category=Category::create([
            'category_id'=>$request->get('category_id'),
            'title'=>$request->get('title'),
            'slug'=>$request->get('slug')
        ]);

        // هر گروه ویژگی که برای دسته بندی تیک زدیم ذخیره میکنه در دیتابیس
        $category->propertyGroups()->attach($request->get('properties'));

        return redirect(route('admin.categories.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit',[
            'category'=>$category,
            'categories'=>Category::all(),
            'properties' => PropertyGroup::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $category->update([
            'category_id'=>$request->get('category_id'),
            'title'=>$request->get('title'),
            'slug'=>$request->get('slug')
        ]);
        // هرگروه ویژگی که تیکش بزنیم موقع ویرایش نمایش میده هر کدوم تیکش برداریم حذف میکنه
        $category->propertyGroups()->sync($request->get('properties'));

        return redirect(route('admin.categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // وقتی دسته بندی حذف میکینیم گروه ویژگی ها هم باید حذف بشن
        $category->propertyGroups()->detach();
        
        $category->delete();

        return redirect(route('admin.categories.index'));
    }
}

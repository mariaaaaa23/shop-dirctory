<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\propertyGroupsRequest;
use App\Models\Category;
use App\Models\PropertyGroup;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class PropertyGroupController extends Controller
{
    public static function middleware():array
    {
        return[
            new Middleware('permission:manage propertyGroups', only:['index','create','store','edit','update','destroy'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // با استفاده از with دسته بندی های متصل به هرگروه رو همزمان میگیریم
        $propertyGroups = PropertyGroup::with('categories')->get();

        return view('admin.property_groups.index',
            compact('propertyGroups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.property_groups.create',
            compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(propertyGroupsRequest $request)
    {
        $groups = PropertyGroup::create([
            'title' => $request->title
        ]);

        // متصل کردن گروه به دسته بندی های انتخاب شده
        // متد attach ایدی های د سته بندی رو میگیره و در جدول واسط میریزه
        $groups->categories()->attach($request->categories);

        return redirect()->route('admin.property_groups.index')->with('success', 'گروه ویژگی با موفقیت ساخته شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(PropertyGroup $propertyGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropertyGroup $propertyGroup)
    {
        $categories = Category::all();

        //پیدا کردن ایدی دسته بندی هایی که قبلا برای این گروه انتخاب شده
        $selectedCategories = $propertyGroup->categories->pluck('id')->toArray();

        return view('admin.property_groups.edit',
            compact('propertyGroup','categories','selectedCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(propertyGroupsRequest $request, PropertyGroup $propertyGroup)
    {
        $propertyGroup->update([
            'title' => $request->title
        ]);

        // پاک کردن دسته بندی های قدیمی و ثبت جدیدها
        $propertyGroup->categories()->sync($request->categories);

        return redirect()->route('admin.property_groups.index')->with('success','تغییرات با موفقیت ثبت شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyGroup $propertyGroup)
    {
        $propertyGroup->delete();

        return back()->with('success', 'گروه ویژگی با موفقیت حذف شد');
    }
}

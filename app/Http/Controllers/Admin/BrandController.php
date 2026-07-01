<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandUpdateRequest;
use App\Http\Requests\Admin\NewBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:manage brand', only:['index','create','store','edit','update','destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::latest()->paginate(10);

        return view('admin.brands.index',
          compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewBrandRequest $request)
    {
        $data = $request->validated();

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('brands','public');
        }

        Brand::create($data);

        return redirect()->route('admin.brands.index')->with('success', 'برند جدید با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit',
           compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandUpdateRequest $request, Brand $brand)
    {
        $data = $request->validated();

        if($request->hasFile('image')){
            if($brand->image){
                Storage::disk('public')->delete($brand->image);
            }

            $data['image'] = $request->file('image')->store('brands','public');
        }

        $brand->update($data);

        return redirect()->route('admin.brands.index')->with('success', 'اطلاعات برند بروزرسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        if($brand->image){
            Storage::disk('public')->delete($brand->image);
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'برند مورد نظر با موفقیت حذف شد');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProductPropertyController extends Controller
{
    public static function middleware()
    {
        return[
            new Middleware('permission:manage own productproperties', only:['index','create','store'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        return view('admin.product_property.index',[
            'product' => $product
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        $product->load('category.propertyGroups');

        $propertyGroups = $product->category ? $product->category->propertyGroups : collect();

        return view('admin.product_property.create', [
            'product' => $product,
            'propertyGroups' => $propertyGroups
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        $properties = collect($request->get('properties'))->filter(function ($item) {
            if(!empty($item['value'])){
                return $item;
            }
        });

        $product->properties()->sync($properties);
        
        return redirect()->route('admin.products.index')->with('success', 'مشخصات با موفقیت ذخیره شد');
    }


}

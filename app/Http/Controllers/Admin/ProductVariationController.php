<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductVariationRequest;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;

class ProductVariationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $product->load('variations');
        return view('admin.products.variations', compact('product'));
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
    public function store(ProductVariationRequest $request, Product $product)
    {
        $imagePath = null;
        if($request->hasFile('image')){
            $imagePath = $request->file('image')->store('client/images','public');
        }

        $product->variations()->create([
            'color_name' => $request->color_name,
            'color_code' => $request->color_code,
            'price' => $request->price,
            'image' => $imagePath,
            'stock' => $request->stock
        ]);

        return redirect()->back()->with('success', 'ویژگی ها با موفقیت اضافه شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductVariation $productVariation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductVariation $productVariation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductVariation $productVariation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariation $Variation)
    {
        $Variation->delete();

        return redirect()->back()->with('success', 'ویژگی ها با موفقیت حذف شد');
    }
}

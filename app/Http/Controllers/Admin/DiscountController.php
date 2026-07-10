<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DiscountRequest;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DiscountController extends Controller
{

    public static function middleware(): array
    {
            return[
                new Middleware('permission:manage own discounts', only:['create','store','destroy'])
            ];
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        return view('admin.discounts.create', [
            'product'=> $product,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiscountRequest $request, Product $product)
    {
        $product->addDiscount($request->value);

        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount, Product $product)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiscountRequest $request, Discount $discount, Product $product)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->deleteDiscount();

        return back()->with('success', 'تخفیف محصول حذف شد');
    }
}

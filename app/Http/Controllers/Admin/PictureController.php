<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Picture;
use Illuminate\Http\Request;
use App\Http\Requests\ProductPictureRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PictureController extends Controller
{ 

    public static function middleware()
    {
        return[
            new Middleware('permission: manage pictures', only:['index','store','destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        return view('admin.pictures.index',[
            'product' => $product
        ]);
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
    public function store(Request $request, Product $product)
    {
        $product->addPicture($request);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Picture $picture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Picture $picture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Picture $picture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, Picture $picture)
    {
        $product->deletePicture($picture);

        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PropertyRequest;
use App\Models\Property;
use App\Models\PropertyGroup;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PropertyController extends Controller
{
    public static function middleware():array
    {
        return[
            new Middleware('permission:manage properties', only:['index','create','store','edit','update','destroy'])
        ];
    }

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::with('propertyGroup')->get();

        return view('admin.properties.index',
            compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = PropertyGroup::all();

        return view('admin.properties.create',
           compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PropertyRequest $request)
    {
        Property::create([
            'title' => $request->title,
            'property_group_id' => $request->property_group_id
        ]);

        return redirect()->route('admin.properties.index')->with('success', 'ویژگی با موفقیت ایجاد شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        $groups = PropertyGroup::all();

        return view('admin.properties.edit',
            compact('groups','property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PropertyRequest $request, Property $property)
    {
        $property->update([
            'title' => $request->title,
            'property_group_id' => $request->property_group_id
        ]);

        return redirect()->route('admin.properties.index')->with('success', 'ویژگی با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $property->delete();

        return back()->with('success', 'ویژگی با موفقیت حذف شد');
    }
}

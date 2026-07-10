<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Event\Application\Started;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SliderController extends Controller
{

    public static function middleware()
    {
        return[
            new Middleware('permission:manage sliders', only:['index','create','store','edit','update','destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.sliders.index',[
            'sliders' => Slider::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sliders = Slider::all();

        return view('admin.sliders.create',[
            'sliders' => $sliders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderRequest $request)
    {
        $path = $request->file('image')->storeAs('sliders', $request->file('image')->getClientOriginalName(), 'public');

        Slider::query()->create([
            'links' => $request->get('links'),
            'image' => $path
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'اسلایدر با موفقیت ایجاد شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        $sliders = Slider::all();

        return view('admin.sliders.edit',
            compact('slider')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'links' => ['required']
        ]);

        $path = $slider->image;

        if($request->hasFile('image')){
            $path = $request->file('image')
            ->storeAs('sliders', $request->file('image')->getClientOriginalName(), 'public');
        }

        $slider->update([
            'links' => $request->get('links'),
            'image' => $path
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'اسلایدر با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        Storage::delete($slider->image);

        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'اسلایدر با موفقیت حذف شد');
    }
}

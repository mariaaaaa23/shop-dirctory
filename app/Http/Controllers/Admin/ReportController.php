<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::with(['user', 'product'])->where('is_seen', false)->latest()->paginate(10);

        return view('admin.reports.index', compact('reports'));
    }


    public function markAsSeen($id)
    {
        $report = Report::findOrFail($id);

        $report->update(['is_seen' => true]);

        return back()->with('success', 'گزارش بایگانی شد');
    }


    public function destroyPost($id)
    {
        $post = Product::findOrFail($id);

        $post->delete();

        return back()->with('success', 'آگهی متخلف با موفقیت حذف شد');
    }

    public function blockUser($id)
    {
        $user = User::findOrFail($id);

        if($user->hasRole('admin') || $user->id == auth()->id()){
            return back()->with('error', 'شما نمیتوانید اکانت مدیریت را حذف کید');
        }

        $user->delete();

        return back()->with('success', 'کاربر متخلف مسدود شد');
    }
   
}

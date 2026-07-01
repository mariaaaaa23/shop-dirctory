<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        //گرفتن همه سفارشات همراه با اطلاعات کاربر خریدار
        $orders = Order::with('user','coupon')->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        //گرفتن اطلاعات کد تخفیف از دیتابیس
        $order = Order::with('coupon', 'user')->findOrFail($id);

        return view('admin.orders.index', compact('order'));
    }

    //تابع آپدیت وضعیت سفارش
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->status = $request->input('status');
        $order->tracking_code = $request->input('tracking_code');
        $order->save();

        return redirect()->back()->with('success', 'وضعیت سفارش با موفقیت بروزرسانی شد');
    }
}

<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ReportRequest;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportConroller extends Controller
{
    public function storeReport(ReportRequest $request, $id)
    {
        Report::create([
            'user_id' => auth()->id(),
            'product_id' => $id,
            'reason' => $request->reason,
            'description' => $request->description
        ]);

        return back()->with('success', 'گزارش شما با موفقیت ثبت شد و توسط ادمین بررسی خواهد شد');
    }
}

<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\RegisterRequest;
use App\Http\Requests\Client\SmsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Http;
use IPPanel\Client;

class RegisterController extends Controller
{
    public static function middleware()
    {
        return[
            new Middleware('auth', only:['logout']),
        ];
    }
    public function create(){
        return view('client.register.create');
    }

    public function store(RegisterRequest $request)
    {
        if(!$request->filled('sms_code') || $request->sms_code != session('sms_code'))
        {
            return back()->withErrors(['sms_code' => 'کد تایید وارد شده اشتباه است'], 400);
        }

        if($request->phone != session('sms_phone')){
            return back()->withErrors(['phone' => 'شماره موبایل با شماره دریافت کننده کد مطابقت ندارد'], 400);
        }
        
        $user = User::create([
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'status' => 'user'
        ]);

        session()->forget(['sms_code', 'sms_phone']);

        // ورود خودکار پس از ثبت نام
        Auth::login($user);

        return redirect('/')->with('success', 'خوش آمدید');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('client.index');
    }

     // ارسال کد 4رقمی پنل پیامکی یکتا هاست 
     public function sendSms(SmsRequest $request)
     {
        $apiKey = 'YTIyZGEwMmEtNmJmNS00ZTkyLWIxYjAtY2IyMmJiYzgyN2MwN2Y4NWNiNGRiNDk5YTdkYzA3ZDUzNWNlYTc1YzQ1NjY='; 
        $patternCode = '2l91uhag2bdq2rj'; 
        $senderNumber = '3000505'; // خط اختصاصی که پشتیبانی گفته

        // 3. تولید کد تایید (برای تست فعلاً یک کد ثابت بگذار تا مطمئن شوی لاجیک کار می‌کند)
        $code = "1234"; 

        // 4. ارسال درخواست به وب‌سرویس یکتا هاست
        $response = Http::withHeaders([
            'apikey' => $apiKey,
            'Accept' => 'application/json',
        ])->post('https://sms.yektahosting.ir/api/v1/send/pattern', [
            'pattern_code' => $patternCode,
            'mobile' => $request->mobile,
            'sender' => $senderNumber, // استفاده از خطی که پشتیبانی اعلام کرد
            'input_data' => [
                'code' => "1234", // دقت کن در پنل نام متغیر حتما code باشد
            ],
        ]);

        // پاسخ به کلاینت (جاوااسکریپت)
        if ($response->successful()) {
            session(['sms_code' => $code, 'sms_phone' => $request->phone]);
            return response()->json([
                'success' => true, 
                'message' => 'کد ارسال شد'
            ]);
        } else {
            return response()->json([
                'success' => false, 
                'message' => 'خطا: ' . $response->body()
            ], 500);
        }
    }
    
}



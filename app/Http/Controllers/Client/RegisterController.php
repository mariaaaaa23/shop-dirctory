<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

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
        
        $user = User::create([
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'status' => 'user'
        ]);

        // ورود خودکار پس از ثبت نام
        Auth::login($user);

        return redirect('/')->with('success', 'حساب کاربری شما با موفقیت ساخته شد');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('client.index');
    }
}

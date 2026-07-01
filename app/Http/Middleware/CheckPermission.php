<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        // ابتدا باید مطمئن بشیم که کاربر لاگین کرده یا نه
        if(!Auth::check()){
            return redirect()->route('client.register')->with('error', 'لطفا ابتدا وارد حساب خود شوید');
        }

        /**
         * @var \App\Models\User $user 
         */
        $user = Auth::user();

        // اگه کاربر نقش ادمین داشت به همه چی دسترسی داشته باشه
        if($user->hasRole('admin')){
            return $next($request);
        }

        // ✨ مریم جان این تیکه‌ کد رو اضافه کن:
        // اگه هیچ پرمیشنی برای روت تعریف نشده بود، یعنی همین که کاربر لاگین هست کافیه و می‌تونه رد بشه
        if (empty($permissions)) {
            return $next($request);
        }

        // بررسی میکنیم آیا کاربر حداقل یکی از پرمشن های ورودی رو داره یانه
        foreach($permissions as $permission){
            if($user->can($permission)){
                return $next($request);
            }
        }

        abort(403, 'شما دسترسی لازم برای انجام این عملیات ندارید');
    }
}
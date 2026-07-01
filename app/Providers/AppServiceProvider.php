<?php

namespace App\Providers;

use App\Observers\CategoryObserver;
use Illuminate\Support\ServiceProvider;
use App\Models\Brand;
use App\Models\Category;
use App\Models\State;
use App\Models\User;
use App\Observers\RoleObserver;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Role;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //اشتراک گذاری متغییر استان ها با تمامی صفحات بلید سایت
        view()->share('provinces', State::all());


        view::composer(['client.*'], function($view){
           // این کد باعث میشه دسته‌بندی‌ها (categories) و برندها (brands)به صورت خودکار به بعضی ویوها ارسال بشن، بدون اینکه توی هر کنترلر جداگانه بنویسی.

           $view->with([

            // در جدول categories اگر category_id = null باشد یعنی دسته اصلی (Parent Category) است زیرمجموعه نیست
        'categories'=>Category::query()->where('category_id', null) ->get(),
        'brands'=>Brand::all(),
        ]);
        });


        Category::observe(CategoryObserver::class);
        Role::observe(RoleObserver::class);
    }
}

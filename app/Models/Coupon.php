<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'percent',
        'expires_at',
        'is_active'
    ];

    //لاراول به طور خودکار تاریخ دیتابیس را به شی کربن تبدیل میکنه
    protected $casts = ['expires_at','datetime'];

    //تابع برای بررسی معتبر بودن تاریخ تخفیف
    public function isValid()
    {
        //اگر فعال بود و تاریخ فعلی قبل از تاریخ انقضا بود معتبر است
        return $this->is_active && Carbon::now()->lt($this->expires_at);
    }
}

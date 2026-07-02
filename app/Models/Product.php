<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'brand_id',
        'slug',
        'cost',
        'image',
        'description',
        'user_id',
        'city_id',
        'status'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function pictures()
    {
        return $this->hasMany(Picture::class);
    }


    public function addPicture(Request $request)
    {
        $path = $request->file('path')->storeAs(
            'products/pictures',
            $request->file('path')->getClientOriginalName(), 'public'
        );

        $this->pictures()->create([
            'path' => $path,
            'mime' => $request->file('path')->getClientMimeType(),
        ]);
    }

    public function deletePicture(Picture $picture)
    {
        Storage::disk('public')->delete($picture->path);

        $picture->delete();
    }




    public function discount()
    {
        return $this->hasOne(Discount::class);
    }

    public function addDiscount($value)
    {
        // چک میکنیم اگر از قبل تخفیف داشت فقط مقدار رو آپدیت کنه
        if($this->has_discount){
            $this->discount()->update(['value' => $value]);
        }

        // اگه نداشت رکورد جدید بساز
        return $this->discount()->create(['value' => $value]);
    }

    public function deleteDiscount()
    {
        return $this->discount()->delete();
    }

    // تابع بررسی وجود تخفیف
    public function getHasDiscountAttribute()
    {
        // اگه تخفیف داشت، قیمت محاسباتی را برگردان وگرنه قیمت اصلی
        return $this->discount()->exists();
        
    }

    // تابع بررسی مقدار تخفیف
    public function getDiscountValueAttribute()
    {
        // بررسی میکنه ببینم تخفیفی وجود داره یانه 
        return $this->has_discount ?
        // اگه تخفیف وجود داشت همون درصد رو برمیگردونه اگه نخغیع نداشت 0 رو برمیگردونه
        $this->discount->value : 0;
    }

    // تابع محاسبه مقدار تخفیف (قیمت نهایی)
    public function getWithDiscountAttribute()
    {
        // اگه تخفیف وجود نداشت قیمت اصلی نمایش میده
        if(!$this->has_discount){
            return $this->cost;
        }

        // محاسبه قیمت تخفیف با درصد
        $discountAmount = ($this->cost * $this->discount_value) / 100;

        return $this->cost - $discountAmount;
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'product_properties')->withPivot('value')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    public function getIsLikedAttribute()
    {
        return $this->likes()->where('user_id', Auth::id())->exists();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class, 'product_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}

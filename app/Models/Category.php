<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'categories';
    protected $guarded = [];


    // دسته والد
    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

// فرزندان دسته
    public function children()
    {
        return $this->hasMany(Category::class, 'category_id');
    }

     // وقتی دسته بندی اصلی داریم هر دسته بندی که باشه این تابع میاد و اگه اون دسته بندی چایلدی که داشته باشه میاد اون محصولاد همه چایلد های اون دسته بندی رو برامون برمیگردونه 
     public function getAllSubCategoryProducts()
     {
         // ایدی فرزندان کتگوری خاص رو برامون برگردون
         $childrenIds=$this->children()->pluck('id');
 
         // همه‌ی محصولاتی را بگیر که یا داخل زیر‌دسته‌ها هستند یا مستقیماً متعلق به خودِ این دسته‌اند
 
         // یعنی: «یک کوئری جدید روی مدل Product بساز»
         return Product::query()
         // محصولاتی را انتخاب کن که category_id آن‌ها داخل آرایه‌ی $childrenIds باشد (معمولاً آی‌دیِ زیر‌دسته‌ها)
         ->whereIn('category_id', $childrenIds)
         // محصولاتی که category_id  آن‌ها برابر با آیدی همین دسته فعلی است  یعنی خود دسته بندی های زنانه و مردانه و غیره
         ->orWhere('category_id', $this->id)
         // کوئری اجرا شود و نتیجه‌ها به صورت یک Collection برگردانده شود
         ->get();
     }
 
     // این تابع برای نمایش زیر دسته های سایدبار
     public function getHasChildrenAttribute()
     {
         return $this->children()->count()>0;
     }
 


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function propertyGroups()
    {
        return $this->belongsToMany(PropertyGroup::class);
    }


    public function hasPropertyGroup(PropertyGroup $propertyGroup)
    {
        // چک میکنه ببینم برای این دسته بندی گروه ویژگی وجود داره یانه
        return $this->propertyGroups()->where('property_group_id', $propertyGroup->id)->exists();
    }
}

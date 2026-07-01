<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'title',
        'property_group_id'
    ];

    public function propertyGroup()
    {
        return $this->belongsTo(PropertyGroup::class);
    }

    // این تابع برای اینکه وقتی برای محصولی مقداری وجود داره مکایش بدیم مقدار رو
    public function getValueForProduct(Product $product)
    {
        // بررسی محصولی که انتخاب کردیم
        $productPropertyQuery = $this->products()->where('product_id', $product->id);

        // اگه ویژگی برای این محصول وجود نداشت نال بر میگردونه
        if(!$productPropertyQuery->exists()){
            return null;
        }
        // وگرنه اگه مقدار product_property وجود داشت ثبت میکنیم در جدول واسط
        return $productPropertyQuery->first()->pivot->value;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_properties')->withPivot('value');
    }
}

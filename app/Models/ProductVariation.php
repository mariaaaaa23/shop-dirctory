<?php

namespace App\Models;

use Faker\Core\Color;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $table = 'product_variations';

    protected $fillable = [
        'product_id',
        'color_name',
        'color_code',
        'price',
        'image',
        'stock',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}

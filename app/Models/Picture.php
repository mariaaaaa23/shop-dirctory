<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $fillable = [
        'product_id',
        'path',
        'mime'
    ];

    public function products()
    {
        return $this->belongsTo(Picture::class);
    }
}

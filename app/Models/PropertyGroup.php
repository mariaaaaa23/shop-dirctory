<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyGroup extends Model
{
    protected $fillable = [
        'title'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}

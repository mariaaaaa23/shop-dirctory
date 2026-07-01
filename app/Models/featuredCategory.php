<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class featuredCategory extends Model
{
    protected $fillable = ['category_id'];

    public $incrementing = false;

    protected $primaryKey = 'category_id';

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_-id');
    }


    public function propertyGroups()
    {
        return $this->belongsToMany(PropertyGroup::class, 'featured_category_proprty_group','featured_category_id','property_group_id');
    }


    public function hasPropertyGroup(PropertyGroup $propertyGroup)
    {
        // چک میکنه ببینم برای این دسته بندی گروه ویژگی وجود داره یانه
        return $this->propertyGroups()->where('property_group_id', $propertyGroup->id)->exists();
    }

    
}

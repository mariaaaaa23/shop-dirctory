<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            
            'manage own comments',
            'manage own discounts',
            'manage own products',
            'manage own productGalleries',
            'manage own productProperties',
            'manage own productVariations',

            // ویرایش همه آگهی ها مخصوص ادمین
            'manage categories',
            'manage cities',
            'manage roles',
            'manage users',
            'manage brands',
            'manag posts',
            'manage properties',
            'manage coupons',
            'manage featuredCategories',
            'manage reports',
            'manage sliders',
            'manage own pictures',
            'view-dashboard',
            'create comments',
            'view posts',
            'view comments',
            'login users',
            'register users',
            'logout users',
            'manage own cartItems',
            'likeProducts',
            'view home',
        ];

        
        foreach($permissions as $permission){
            Permission::findOrCreate($permission);
        }
    }
}

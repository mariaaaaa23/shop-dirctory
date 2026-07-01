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
            // ایجاد پست مربوط به خود کاربر
            'create posts',

            // ویرایش پست فقط آگهی خود شخص
            'edit own posts',
            'delete own posts',

            // ویرایش همه آگهی ها مخصوص ادمین
            'edit any posts',
            'delete any posts',
            'manage categories',
            'manage cities',
            'manage roles',
            'manage users',
            'manage brands',
            'manag posts',
            'manage discounts',
            'manage properties',
            'manage propertyGroups',
            'manage productproperties',
            'manage pictures',
            'view-dashboard',
            'create comments',
            'view posts',
            'delete comments',
            'view comments',
            'login users',
            'register users',
            'logout users'
        ];

        
        foreach($permissions as $permission){
            Permission::findOrCreate($permission);
        }
    }
}

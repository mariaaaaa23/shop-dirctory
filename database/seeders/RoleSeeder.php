<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ساخت نقش ها
        $admin = Role::findOrCreate('admin');
        $author = Role::findOrCreate('author');
        $user = Role::findOrCreate('user');


        // وصل کردن پرمشن ها به نقش ها
        $admin->syncPermissions(Permission::all());
        $author->syncPermissions([
            'create posts',
            'edit own posts',
            'delete own posts',
            'view posts'
        ]);
        $user->syncPermissions(['view posts']);
    }
}

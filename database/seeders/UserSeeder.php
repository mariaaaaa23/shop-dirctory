<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // ایجاد یک کاربر ادمین برای تست
        $user = User::updateOrCreate([
            'phone' => '09172485988',
            'password' => Hash::make('12345678')
        ]);

        // پیدا کردن نقش ادمین که در roleseeder ساختم یعنی میگرده اونو پیدا کنه
        $adminRole = Role::where('name', 'admin')->first();

        // اختصاص نقش به کاربر یعنی به کاربر $user نقش ادمین میده
        if($adminRole && ! $user->hasRole('admin')){
            $user->assignRole($adminRole);
        }
    }
}

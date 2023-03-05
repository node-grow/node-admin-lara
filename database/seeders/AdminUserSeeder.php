<?php

namespace NodeAdminDatabase\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use NodeAdmin\Models\AdminUser;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminUser::query()->create([
            'username' => config('admin.default_admin_username','admin'),
            'password' => Hash::make(config('admin.default_admin_password','admin123')),
        ]);
    }
}

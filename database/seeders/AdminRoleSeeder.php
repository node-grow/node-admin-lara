<?php

namespace NodeAdminDatabase\Seeders;

use Illuminate\Database\Seeder;
use NodeAdmin\Models\AdminRole;
use NodeAdmin\Models\AdminUser;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        AdminRole::query()->truncate();
        $role=AdminRole::query()->create([
            'id' => config('admin.super_admin_role_id'),
            'name' => '超级管理员',
            'description' => '',
        ]);
        AdminUser::query()->update(['role_id'=>$role->id]);
    }
}

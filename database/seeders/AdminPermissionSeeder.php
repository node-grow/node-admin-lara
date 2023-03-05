<?php

namespace NodeAdminDatabase\Seeders;

use Illuminate\Database\Seeder;
use NodeAdmin\Models\AdminPermission;
use NodeAdmin\Models\AdminRole;
use NodeAdmin\Models\AdminRolePermission;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminPermission::query()->truncate();
        $permission=AdminPermission::query()->create([
            'name'=>'所有权限',
            'path'=>'*',
        ]);

        $roles=AdminRole::query()->get();
        foreach ($roles as $role) {
            AdminRolePermission::query()->create([
                'role_id'=>$role->id,
                'permission_id'=>$permission->id,
            ]);
        }
    }
}

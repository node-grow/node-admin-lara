<?php

namespace NodeAdminDatabase\Seeders;

use Illuminate\Database\Seeder;
use NodeAdmin\Models\AdminMenu;

class AdminMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $setting_menu_id = AdminMenu::query()->insertGetId(['sort' => '99', 'title' => '后台管理', 'icon' => 'icon-font-fayun']);

        $insert_data = [
            [
                'name' => 'SysSetting',
                'title' => '系统设置',
                'level' => 2,
                'pid' => $setting_menu_id
            ],
            [
                'name' => 'Users',
                'title' => '用户管理',
                'level' => 2,
                'pid' => $setting_menu_id
            ],
            [
                'name' => 'Role',
                'title' => '角色管理',
                'level' => 2,
                'pid' => $setting_menu_id,
            ],
            [
                'name' => 'Permission',
                'title' => '权限点管理',
                'level' => 2,
                'pid' => $setting_menu_id,
            ],
            [
                'name' => 'Menu',
                'title' => '菜单管理',
                'level' => 2,
                'pid' => $setting_menu_id,
            ],
            [
                'name' => 'Log',
                'title' => '日志查看',
                'level' => 2,
                'pid' => $setting_menu_id,
            ],
        ];

        AdminMenu::query()->insert($insert_data);

    }
}

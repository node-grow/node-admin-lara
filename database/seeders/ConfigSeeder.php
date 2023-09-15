<?php

namespace NodeAdminDatabase\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use NodeAdmin\Models\Config;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Config::query()->truncate();
        DB::table('config')->insert(
            [
                [
                    'name' => 'SITE_NAME',
                    'title'=>'网站名',
                    'type' => 'text',
                    'value' => '我是网站名字',
                    'tips'=>''
                ],
                [
                    'name' => 'LOGO',
                    'title'=>'网站logo',
                    'type' => 'image',
                    'value' => '',
                    'tips' => '图片上传大小是100x100',
                ]
            ]
        );
    }
}

<?php

namespace NodeAdmin\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

class SystemInfoController extends Controller
{
    public function index(){
        $res= [
            'infos'=>[
                [
                    'label'=>'当前服务器时间',
                    'value'=>date('Y-m-d H:i:s'),
                ],
                [
                    'label'=>'服务器类型',
                    'value'=>PHP_OS,
                ],
                [
                    'label'=>'PHP 版本',
                    'value'=>PHP_VERSION,
                ],
                [
                    'label'=>'Laravel 版本',
                    'value'=>app()->version(),
                ],
                [
                    'label'=>'Web 服务',
                    'value'=>$_SERVER['SERVER_SOFTWARE'] ?? '',
                ],
                [
                    'label'=>'PHP 运行模式',
                    'value'=>PHP_SAPI,
                ],
                [
                    'label'=>'服务器 IP',
                    'value'=>$_SERVER['SERVER_ADDR'] ?? '',
                ],
            ]
        ];


        return $res;
    }
}

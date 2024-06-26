<?php

return [
    'default_admin_username' => 'admin',
    'default_admin_password' => 'admin123',

    'auth' => [
        'driver' => 'passport',
        'provider' => 'admin_api',
    ],

    'iconfont_symbol_url' => '//at.alicdn.com/t/font_3332360_8cknlj6abln.js',

    'captcha' => [
        'length' => 4,
        'width' => 120,
        'height' => 36,
        'quality' => 90,
        'math' => false,
        'expire' => 60,
        'encrypt' => false,
    ],
    'default_tabs' => [
        [
            "title" => "平台概况",
            "url" => "/dashboard",
            "type" => "inner_path",
            "closable" => false
        ]
    ],

    'modules' => [
        'admin' => [ // 默认模块，请勿删除
            'nav' => '平台',
            'route' => [
                'name' => 'admin.',
                'file' => base_path('routes/admin.php'),
                'prefix' => '/admin',
            ]
        ],
    ],

    'super_admin_role_id' => 1,

    'extra_scripts' => [],

];

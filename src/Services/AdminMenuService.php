<?php

namespace NodeAdmin\Services;

use Illuminate\Support\Facades\Validator;

class AdminMenuService
{

    public function saveVidation()
    {
        Validator::make(\request()->input(), [
            'title' => 'required',
//            'name' => 'required'
        ], [], ['title' => '菜单名'])->validate();

        $title = request()->input('title');
        $name = request()->input('name');
        $pid = request()->input('pid');
        $url = request()->input('url');
        $icon = request()->input('icon');

        return [
            'title' => $title,
            'name' => $name,
            'icon' => $icon,
            'pid' => $pid,
            'url' => $url
        ];
    }
}

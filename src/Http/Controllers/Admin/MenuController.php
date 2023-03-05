<?php

namespace NodeAdmin\Http\Controllers\Admin;

use NodeAdmin\Lib\ResourceController;
use NodeAdmin\Models\AdminMenu;

class MenuController extends ResourceController
{
    public function getMenu()
    {
        $data_list = AdminMenu::query()->orderBy('sort')->get()->toArray();
        $res = $this->getChildMenu($data_list);
        return $res;
    }

    public function getChildMenu($data_list, $pid = 0)
    {
        $data = [];
        foreach ($data_list as $k => $v) {
            if ($v['pid'] == $pid) {
                $child = $this->getChildMenu($data_list, $v['id']);
                $v['children'] = $child ?: [];
                $v['url'] = $v['url'];
                if(!$v['url']){
                    $v['url'] = '/'.lcfirst($v['name']);
                }
                $v['operation'] = [
                    'type'=>'add_tab',
                    'option'=>[
                        'title'=>$v['title'],
                        'url'=>$v['url'],
                        'type'=>'node_content'
                    ]
                ];
                $data[] = $v;
            }
        }
        return $data;
    }


}

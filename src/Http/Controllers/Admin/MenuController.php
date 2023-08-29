<?php

namespace NodeAdmin\Http\Controllers\Admin;

use NodeAdmin\Lib\ResourceController;
use NodeAdmin\Models\AdminMenu;

class MenuController extends ResourceController
{
    protected $route_badge = [];
    protected $module_badge = [];

    public function getModule()
    {
        $res = [];
        foreach (config('admin.modules') as $key => $module) {
            $res[] = [
                'name' => $key,
                'nav' => $module['nav'],
                'badge' => $this->module_badge[$key] ?? '',
            ];
        }
        return $res;
    }

    public function getMenu($module = 'admin')
    {
        $data_list = AdminMenu::query()
            ->where('module', $module)
            ->orderBy('sort')
            ->get()->toArray();
        return $this->getChildMenu($data_list, $module);
    }

    protected function getChildMenu($data_list, $module, $pid = 0)
    {
        $data = [];
        foreach ($data_list as $v) {
            if ($v['pid'] == $pid) {
                $child = $this->getChildMenu($data_list, $module, $v['id']);
                $v['children'] = $child ?: [];
                if (!$v['url'] && $v['name']) {
                    $route_name = config('admin.modules')[$module]['route']['name'] . lcfirst($v['name']) . '.index';
                    $v['url'] = route($route_name);
                    $v['badge'] = $this->route_badge[$route_name] ?? '';
                }
                $v['operation'] = [
                    'type' => 'add_tab',
                    'option' => [
                        'title' => $v['title'],
                        'url' => $v['url'],
                        'type' => 'node_content'
                    ]
                ];
                $data[] = $v;
            }
        }
        return $data;
    }


}

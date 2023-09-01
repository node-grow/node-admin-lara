<?php

namespace NodeAdmin\Http\Controllers\Admin;

use NodeAdmin\Lib\ResourceController;
use NodeAdmin\Models\AdminMenu;
use NodeAdmin\Services\AdminPermissionService;

class MenuController extends ResourceController
{
    protected $route_badge = [];
    protected $module_badge = [];


    protected $permission_service;

    public function __construct(AdminPermissionService $service)
    {
        $this->permission_service = $service;
    }

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
            if ($v['pid'] != $pid) {
                continue;
            }
            $child = $this->getChildMenu($data_list, $module, $v['id']);
            $v['children'] = $child ?: [];
            if (!$v['url'] && $v['name']) {
                $route_name = config('admin.modules')[$module]['route']['name'] . lcfirst($v['name']) . '.index';
                $v['url'] = route($route_name);
                $v['badge'] = $this->route_badge[$route_name] ?? '';

                $route = app('router')->getRoutes()->getByName($route_name);
                if (!$this->permission_service->check($route, request()->user())) {
                    continue;
                }
            }
            if ($v['url']) {
                $v['operation'] = [
                    'type' => 'add_tab',
                    'option' => [
                        'title' => $v['title'],
                        'url' => $v['url'],
                        'type' => 'node_content'
                    ]
                ];
            }
            if (!($v['operation'] ?? '') && !$v['children']) {
                continue;
            }
            $data[] = $v;
        }

        return $data;
    }


}

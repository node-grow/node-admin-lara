<?php

namespace NodeAdmin\Services;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use NodeAdmin\Exceptions\NodeException;
use NodeAdmin\Models\AdminPermission;
use NodeAdmin\Models\AdminUser;

class AdminPermissionService
{
    protected function getRules()
    {
        return [
            'name' => 'required',
            'description' => '',
            'pid' => '',
            'routes' => 'required',
        ];
    }

    protected function getAttributes()
    {
        return [
            'name' => '权限点名称',
            'description' => '描述',
            'routes' => '权限点路径',
        ];
    }

    public function create(Request $request)
    {
        $data = $request->validate($this->getRules(), [], $this->getAttributes());
        $permission = new AdminPermission();
        foreach ($data as $k => $v) {
            $permission->$k = $v;
        }
        $r = $permission->save();
        if ($r === false) {
            throw new NodeException('保存失败');
        }
    }

    public function update(Request $request, AdminPermission $permission)
    {
        $data = $request->validate($this->getRules(), [], $this->getAttributes());
        foreach ($data as $k => $v) {
            $permission->$k = $v;
        }
        $r = $permission->save();
        if ($r === false) {
            throw new NodeException('保存失败');
        }
    }

    public function getAllPermissionRoutes(): array
    {
        $permissions = AdminPermission::query()->get();
        $routes = [];

        foreach ($permissions as $permission) {
            $routes = array_merge_recursive($routes, explode("\n", $permission->routes));
        }

        return $routes;
    }

    public function check(Route $route, AdminUser $user): bool
    {
        if ($user->role->id == config('admin.super_admin_role_id')) {
            return true;
        }
        $routes = $user->permission_routes;
        return $this->checkRoutes($routes, $route);
    }

    protected function checkRoutes(array $routes, Route $route): bool
    {
        $all_routes = $this->getAllPermissionRoutes();
        $c = false;
        foreach ($all_routes as $a_route) {
            $route->named($a_route) && $c = true;
        }

        if (!$c) {
            return true;
        }
        foreach ($routes as $a_route) {
            if ($route->named($a_route)) {
                return true;
            }
        }
        return false;
    }

}

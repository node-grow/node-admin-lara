<?php

namespace NodeAdmin\Http\Controllers\Admin;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use NodeAdmin\Exceptions\NodeException;
use NodeAdmin\Lib\NodeContent\Form;
use NodeAdmin\Lib\NodeContent\NodeResponse;
use NodeAdmin\Lib\NodeContent\Table;
use NodeAdmin\Lib\ResourceController;
use NodeAdmin\Lib\ResourceControllerTrait;
use NodeAdmin\Models\AdminPermission;
use NodeAdmin\Services\AdminPermissionService;

class PermissionController extends ResourceController
{
    use ResourceControllerTrait;

    public function table(Table $table)
    {
        $table->actions(function (Table\ActionsContainer $container){
            $container->create()->defaultOperation();
        });
        $table->columns(function (Table\ColumnsContainer $container) {
            $container->text('name', '权限点名称');
            $container->text('description', '描述');
            $container->text('routes_limit', '权限点路由');
            $container->actions('')->setActions(function (Table\Columns\Actions\ActionsContainer $container){
                $container->edit()->defaultOperation('permission');
                $container->delete()->defaultOperation('permission');
            });
        });
    }

    public function dataList()
    {
        $data_list = AdminPermission::query()->get();
        return $this->transformDataList(
            treeForCollection($data_list->map(function (AdminPermission $permission) {
                $permission->routes_limit = Str::limit($permission->routes, 20);
                return $permission;
            }))
        );
    }

    public function create(Form $form)
    {
        $form->items(function (Form\ItemsContainer $container){
            $container->input('name','权限点名称');
            $container->input('description', '描述');
            $container->textarea('routes', '权限点路由', '可带星号*，多个可换行')
                ->setAutoComplete($this->getUnregisterRoutes()->map(fn(\Illuminate\Routing\Route $route) => $route->getName())->toArray());

            $select = $this->getPermissionSelect();
            $container->select('pid', '上级权限点', '不选则为根权限')->setOptions($select);
        });
        $form->actions(function (Form\ActionsContainer $container){
            $container->submit()->request(action([get_class($this), 'store']), 'post');
        });
        return $form;
    }

    public function edit(AdminPermission $permission,Form $form)
    {
        $form->items(function (Form\ItemsContainer $container) use ($permission) {
            $container->input('name','权限点名称');
            $container->input('description', '描述');
            $container->textarea('routes', '权限点路由', '可带星号*，多个可换行')
                ->setAutoComplete($this->getUnregisterRoutes()->map(fn(\Illuminate\Routing\Route $route) => $route->getName())->toArray());

            $select = $this->getPermissionSelect($permission);
            $container->select('pid', '上级权限点', '不选则为根权限')->setOptions($select);
        });
        $form->setData($permission->toArray());
        $form->actions(function (Form\ActionsContainer $container) use ($permission) {
            $container->submit()->request(action([get_class($this), 'update'],['permission'=>$permission]), 'put');
        });
        return $form;
    }

    public function update(AdminPermission $permission,AdminPermissionService $service)
    {
        $service->update(request(),$permission);
        return new NodeResponse('','保存成功');
    }

    public function store(AdminPermissionService $service)
    {
        $service->create(request());
        return new NodeResponse('','新增成功');
    }

    public function destroy(AdminPermission $permission)
    {
        $r=$permission->deleteOrFail();
        if (!$r){
            throw new NodeException('删除失败');
        }
        return new NodeResponse('','删除成功');
    }

    protected function getPermissionSelect(AdminPermission $extra = null)
    {
        $data = AdminPermission::query()->where('id', '<>', $extra->id ?? '')->get()->toArray();
        $select = [];
        foreach ($data as $d) {
            $select[] = ['label' => $d['name'], 'value' => $d['id']];
        }
        return $select;
    }


    protected function getUnregisterRoutes()
    {
        $service = new AdminPermissionService();

        $list = new Collection();
        $routes = new Collection($service->getAllPermissionRoutes());
        $routes = $routes->filter(fn($r) => !str_contains($r, '*'));

        $all_routes = new Collection(Route::getRoutes()->getRoutes());
        foreach (config('admin.modules') as $module) {
            $prefix_name = $module['route']['name'];

            $module_routes = $all_routes->filter(function (\Illuminate\Routing\Route $route) use ($prefix_name, $routes) {
                if (!$route->named($prefix_name . '*')) {
                    return false;
                }
                if ($routes->search($route->getName()) !== false) {
                    return false;
                }
                $middlewares = $route->gatherMiddleware();
                return array_search('admin:auth', $middlewares) != false;
            });

            $list = $list->union($module_routes)->values();
        }
        return $list;
    }
}

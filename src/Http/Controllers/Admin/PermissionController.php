<?php

namespace NodeAdmin\Http\Controllers\Admin;

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
            $container->text('path', '权限点路径');
            $container->actions('')->setActions(function (Table\Columns\Actions\ActionsContainer $container){
                $container->edit()->defaultOperation('permission');
                $container->delete()->defaultOperation('permission');
            });
        });
    }

    public function dataList()
    {
        $data_list=AdminPermission::query()->paginate(10);
        return $this->transformDataList($data_list);
    }

    public function create(Form $form)
    {
        $form->items(function (Form\ItemsContainer $container){
            $container->input('name','权限点名称');
            $container->textarea('description','描述');
            $container->input('path','权限点路径','可带星号*');
        });
        $form->actions(function (Form\ActionsContainer $container){
            $container->submit()->request(action([get_class($this), 'store']), 'post');
        });
        return $form;
    }

    public function edit(AdminPermission $permission,Form $form)
    {
        $form->items(function (Form\ItemsContainer $container){
            $container->input('name','权限点名称');
            $container->textarea('description','描述');
            $container->input('path','权限点路径','可带星号*');
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
}

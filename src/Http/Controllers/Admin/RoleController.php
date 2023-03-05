<?php

namespace NodeAdmin\Http\Controllers\Admin;

use NodeAdmin\Exceptions\NodeException;
use NodeAdmin\Lib\NodeContent\Form;
use NodeAdmin\Lib\NodeContent\NodeResponse;
use NodeAdmin\Lib\NodeContent\Table;
use NodeAdmin\Lib\ResourceController;
use NodeAdmin\Lib\ResourceControllerTrait;
use NodeAdmin\Models\AdminPermission;
use NodeAdmin\Models\AdminRole;
use NodeAdmin\Services\AdminRoleService;

class RoleController extends ResourceController
{
    use ResourceControllerTrait;

    public function table(Table $table)
    {
        $table->actions(function (Table\ActionsContainer $container){
            $container->create()->defaultOperation();
        });
        $table->columns(function (Table\ColumnsContainer $container){
            $container->text('name','角色名');
            $container->text('description','描述');
            $container->actions('')->setActions(function (Table\Columns\Actions\ActionsContainer $container){
                $container->edit()->defaultOperation('role');
                $container->delete()->defaultOperation('role');
            });
        });
    }

    public function dataList()
    {
        $data_list=AdminRole::query()->paginate(10);
        return $this->transformDataList($data_list);
    }

    public function create(Form $form)
    {
        $form->items(function (Form\ItemsContainer $container){
            $container->input('name','角色名');
            $container->textarea('description','描述');
            $container->custom('permissions','权限')
                ->addItemOption('permissions',treeForCollection(AdminPermission::query()->get()))
                ->setUrl(asset('/assets/node-admin/components/PermissionTransfer.umd.min.js'));
        });
        $form->actions(function (Form\ActionsContainer $container){
            $container->submit()->request(action([get_class($this),'store']),'post');
        });
        $form->setData([
            'permissions'=>[]
        ]);
        return $form;
    }

    public function store(AdminRoleService $service)
    {
        $inputs=request()->input();

        $service->store($inputs);

        return new NodeResponse('新增成功');
    }

    public function edit(AdminRole $role,Form $form)
    {
        $form->setData(array_merge($role->toArray(),['permissions'=>$role->permissions()->get()->toArray()]));
        $form->items(function (Form\ItemsContainer $container){
            $container->input('name','角色名');
            $container->textarea('description','描述');
            $container->custom('permissions','权限')
                ->addItemOption('permissions',treeForCollection(AdminPermission::query()->get()))
                ->setUrl(asset('/assets/node-admin/components/PermissionTransfer.umd.min.js'));
        });
        $form->actions(function (Form\ActionsContainer $container) use ($role) {
            $container->submit()->request(action([get_class($this),'update'],['role'=>$role]),'put');
        });
        return $form;
    }

    public function update(AdminRole $role,AdminRoleService $service)
    {
        $service->update($role,request()->input('permissions'));
        return new NodeResponse('保存成功');
    }

    public function destroy(AdminRole $role)
    {
        $r=$role->deleteOrFail();
        if ($r===false){
            throw new NodeException('删除失败');
        }
        return new NodeResponse('','删除成功');
    }
}

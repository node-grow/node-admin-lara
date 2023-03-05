<?php

namespace NodeAdmin\Http\Controllers\Admin;

use NodeAdmin\Lib\NodeContent\Form;
use NodeAdmin\Lib\NodeContent\NodeResponse;
use NodeAdmin\Lib\NodeContent\Table;
use NodeAdmin\Lib\ResourceController;
use NodeAdmin\Lib\ResourceControllerTrait;
use NodeAdmin\Models\AdminRole;
use NodeAdmin\Models\AdminUser;
use NodeAdmin\Services\AdminUserService;

class AdminUserController extends ResourceController
{
    use ResourceControllerTrait;

    public function table(Table $table)
    {
        $table->actions(function (Table\ActionsContainer $container) {
            $container->create()->defaultOperation();
        });
        $table->columns(function (Table\ColumnsContainer $container) {
            $container->text('id', 'ID');
            $container->text('username', '用户名');
            $container->text('role_name', '角色');

            $container->actions('', '操作')->setActions(function (Table\Columns\Actions\ActionsContainer $container) {
                $container->edit()->defaultOperation('user', '编辑');
                $container->delete()->defaultOperation('user');
            });
        });
    }

    public function dataList()
    {
        $users = AdminUser::query()->with('role')->paginate(10);
        foreach ($users as $user) {
            $user->role_name=$user->role->name;
        }
        return $this->transformDataList($users);
    }

    public function create(Form $form)
    {
        $form->items(function (Form\ItemsContainer $container) {
            $container->input('username', '登录名');
            $container->password('password', '密码');
            $container->select('role_id', '角色')->setOptions(AdminRole::query()->get(),'name','id');
        });
        $form->actions(function (Form\ActionsContainer $container) {
            $container->submit()->request(action([get_class($this), 'store']), 'post');
        });
        return $form;
    }

    public function store(AdminUser $user, AdminUserService $adminUserService)
    {
        list($username, $password) = $adminUserService->saveVidation();
        $user->query()->create([
            'username' => $username,
            'password' => $password
        ]);
        return new NodeResponse('', '新增成功');
    }


    public function edit(AdminUser $user, Form $form)
    {
        $form->items(function (Form\ItemsContainer $container) {
            $container->input('username', '登录名');
            $container->password('password', '密码');
            $container->select('role_id', '角色')->setOptions(AdminRole::query()->get(),'name','id');
        });
        $form->actions(function (Form\ActionsContainer $container) use ($user) {
            $container->submit()->request(action([get_class($this), 'update'], ['user' => $user]), 'put');
        });
        $form->setData($user->toArray());
        return $form;
    }

    public function update(AdminUser $user, AdminUserService $adminUserService)
    {
        list($username, $password) = $adminUserService->saveVidation();
        $user->username = $username;
        $user->password = $password;
        $user->save();
        return new NodeResponse('', '保存成功');
    }

    public function destroy(AdminUser $user)
    {
        $user->destroy([$user->id]);
        return new NodeResponse('','删除成功');
    }

}

<?php

namespace NodeAdmin\Http\Controllers\Admin;

use NodeAdmin\Lib\NodeContent\Form;
use NodeAdmin\Lib\NodeContent\NodeResponse;
use NodeAdmin\Lib\NodeContent\Table;
use NodeAdmin\Lib\ResourceController;
use NodeAdmin\Lib\ResourceControllerTrait;
use NodeAdmin\Models\AdminMenu;
use NodeAdmin\Services\AdminMenuService;

class AdminMenuController extends ResourceController
{
    use ResourceControllerTrait;

    public function table(Table $table)
    {
        $table->actions(function (Table\ActionsContainer $container) {
            $container->create()->defaultOperation();
        });
        $table->columns(function (Table\ColumnsContainer $container) {
            $container->text('title', '菜单名');
            $container->text('url', '路由');
            $container->text('name', '控制器名');
            $container->input('sort', '排序')->request(action([get_class($this),'sort'],['menu'=>'__id__']),'put',[
                'sort'=>'__sort__'
            ]);

            $container->actions('', '操作')->setActions(function (Table\Columns\Actions\ActionsContainer $container) {
                $container->edit()->defaultOperation('menu', '编辑');
                $container->delete()->defaultOperation('menu');
            });
        });
    }

    public function sort(AdminMenu $menu){
        $menu->sort=request()->input('sort');
        $menu->save();
        return new NodeResponse('','保存成功');
    }

    public function dataList()
    {
        $menu = $this->getChildren(0);
        return $this->transformDataList($menu);
    }

    protected function getChildren($pid)
    {
        $menu = AdminMenu::query()->where('pid', $pid)->orderBy('sort')->get();
        foreach ($menu as $m) {
            $children=$this->getChildren($m['id']);
            $m['children'] = $children->count()?$children:null;
        }
        return $menu;
    }

    public function create(Form $form)
    {
        $select = $this->getMenuSelect();
        $form->items(function (Form\ItemsContainer $container) use ($select) {
            $container->select('pid', '所属菜单', '不选则为根目录')->setOptions($select);
            $container->input('title', '菜单名');
            $container->iconfont('icon','图标');
            $container->input('url', '路由');
            $container->input('name', '控制器');
        });
        $form->actions(function (Form\ActionsContainer $container) {
                $container->submit()->request(action([get_class($this), 'store']), 'post');
        });
        return $form;
    }

    public function store(AdminMenu $menu, AdminMenuService $adminMenuService)
    {
        $data = $adminMenuService->saveVidation();
        $menu->query()->create([
            'title' => $data['title'],
            'pid' => $data['pid']?:0,
            'icon' => $data['icon'],
            'url'=>$data['url'],
            'name'=>$data['name']
        ]);
        return new NodeResponse('', '新增成功');
    }


    public function edit(AdminMenu $menu, Form $form)
    {
        $select = $this->getMenuSelect();
        $form->items(function (Form\ItemsContainer $container) use ($select) {
            $container->select('pid', '所属菜单', '不选则为根目录')->setOptions($select);
            $container->input('title', '菜单名');
            $container->iconfont('icon','图标');
            $container->input('url', '路由');
            $container->input('name', '控制器', '请勿随便更改');
        });
        $form->actions(function (Form\ActionsContainer $container) use ($menu) {
            $container->submit()->request(action([get_class($this), 'update'], ['menu' => $menu]), 'put');
        });
        $form->setData($menu->toArray());
        return $form;
    }

    public function update(AdminMenu $menu, AdminMenuService $adminMenuService)
    {
        $data = $adminMenuService->saveVidation();
        $menu->pid = $data['pid'];
        $menu->title =$data['title'];
        $menu->url =$data['url'];
        $menu->name =$data['name'];
        $menu->icon = $data['icon'];
      $menu->save();
        return new NodeResponse('', '保存成功');
    }

    public function destroy(AdminMenu $menu)
    {
        $menu->destroy([$menu->id]);
        return new NodeResponse('', '删除成功');
    }

    public function getMenuSelect(){
        $data =AdminMenu::query()->where('status',1)->get()->toArray();
        $select[] = ['label' => '根菜单', 'value' => 0];
        foreach ($data as $d) {
            $select[] = ['label' => $d['title'], 'value' => $d['id']];
        }
        return $select;
    }

}

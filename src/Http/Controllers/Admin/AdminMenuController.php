<?php

namespace NodeAdmin\Http\Controllers\Admin;

use NodeAdmin\Lib\NodeContent\Form;
use NodeAdmin\Lib\NodeContent\NodeResponse;
use NodeAdmin\Lib\NodeContent\Tab;
use NodeAdmin\Lib\NodeContent\Table;
use NodeAdmin\Lib\ResourceController;
use NodeAdmin\Lib\TableDataListTrait;
use NodeAdmin\Models\AdminMenu;
use NodeAdmin\Services\AdminMenuService;

class AdminMenuController extends ResourceController
{
    use TableDataListTrait;

    public function index(Table $table, Tab $tab, $module = '')
    {
        if (!$module) {
            $tab->tabs(function (Tab\TabContainer $container) {
                foreach (config('admin.modules') as $name => $module) {
                    $container->tab_pane($name, $module['nav'], route('admin.menu.index', ['module' => $name]));
                }
            });
            return $tab;
        }
        if (request()->input('list')) {
            return $this->dataList($module);
        }
        $table->setDataUrl(route('admin.menu.index', ['module' => $module]) . '?list=1');
        $this->table($table, $module);
        return $table;
    }

    public function table(Table $table, string $module)
    {
        $table->columns(function (Table\ColumnsContainer $container) use ($module) {
            $container->text('title', '菜单名');
            $container->text('url', '路由');
            $container->text('name', '控制器名');
            $container->input('sort', '排序')->request(action([get_class($this), 'sort'], ['menu' => '__id__']), 'put', [
                'sort' => '__sort__'
            ]);

            $container->actions('', '操作')->setActions(function (Table\Columns\Actions\ActionsContainer $container) use ($module) {
                $container->edit()->defaultOperation('menu');
            });
        });

    }

    public function sort(AdminMenu $menu)
    {
        $menu->sort = request()->input('sort');
        $menu->save();
        return new NodeResponse('', '保存成功');
    }

    public function dataList(string $module)
    {
        $menu = $this->getChildren(0, $module);
        return $this->transformDataList($menu);
    }

    protected function getChildren($pid, $module)
    {
        $menu = AdminMenu::query()->where('pid', $pid)->where('module', $module)->orderBy('sort')->get();
        foreach ($menu as $m) {
            $children = $this->getChildren($m['id'], $module);
            $m['children'] = $children->count() ? $children : null;
        }
        return $menu;
    }

    public function edit(AdminMenu $menu, Form $form)
    {
        $select = $this->getMenuSelect($menu->module);
        $form->items(function (Form\ItemsContainer $container) use ($select) {
            $container->select('pid', '所属菜单', '不选则为根目录')->setOptions($select);
            $container->input('title', '菜单名');
            $container->iconfont('icon', '图标');
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
        $menu->title = $data['title'];
        $menu->url = $data['url'];
        $menu->name = $data['name'];
        $menu->icon = $data['icon'];
        $menu->save();
        return new NodeResponse('', '保存成功');
    }

    public function getMenuSelect(string $module)
    {
        $data = AdminMenu::query()->where('module', $module)->where('status', 1)->get()->toArray();
        $select[] = ['label' => '根菜单', 'value' => 0];
        foreach ($data as $d) {
            $select[] = ['label' => $d['title'], 'value' => $d['id']];
        }
        return $select;
    }

}

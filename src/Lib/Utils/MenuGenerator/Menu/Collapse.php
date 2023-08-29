<?php

namespace NodeAdmin\Lib\Utils\MenuGenerator\Menu;

use NodeAdmin\Lib\Utils\MenuGenerator\MenuContainer;
use NodeAdmin\Models\AdminMenu;

class Collapse extends BaseMenu
{
    protected MenuContainer $container;

    public function __construct($title, $icon = 'icon-font-bianhao20190805')
    {
        $this->data['title'] = $title;
        $this->data['icon'] = $icon;

        /** @var MenuContainer $container */
        $this->container = app()->make(MenuContainer::class);

        $this->container->setModule($this->data['module']);
    }

    public function children(\Closure $callback)
    {
        app()->call($callback, ['container' => $this->container]);
    }

    public function toDB()
    {
        $t_menu = AdminMenu::query()
            ->where('title', $this->data['title'])
            ->where('module', $this->data['module'])
            ->first();
        if (!$t_menu) {
            $t_menu = AdminMenu::query()->forceCreate([
                'pid' => $this->data['pid'],
                'icon' => $this->data['icon'],
                'title' => $this->data['title'],
                'level' => $this->data['level'],
                'module' => $this->data['module'],
                'status' => 1,
            ]);
        }
        /** @var AdminMenu $t_menu */
        $this->container->run($t_menu);
    }
}

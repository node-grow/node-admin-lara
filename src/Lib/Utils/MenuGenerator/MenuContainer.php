<?php

namespace NodeAdmin\Lib\Utils\MenuGenerator;

use Illuminate\Support\Str;
use NodeAdmin\Lib\Utils\MenuGenerator\Menus\BaseMenu;
use NodeAdmin\Lib\Utils\MenuGenerator\Menus\Collapse;
use NodeAdmin\Lib\Utils\MenuGenerator\Menus\Link;
use NodeAdmin\Models\AdminMenu;

/**
 * @method Collapse collapse($title, $icon = 'icon-font-bianhao20190805')
 * @method Link link($title, $name = '', $url = '')
 */
class MenuContainer
{
    /** @var BaseMenu[] $menus */
    protected $menus = [];
    protected $module = 'admin';


    public function __call(string $name, array $arguments)
    {
        $class = 'NodeAdmin\\Lib\\Utils\\MenuGenerator\\Menus\\' . Str::ucfirst(Str::camel($name));
        if (!class_exists($class)) {
            throw new \RuntimeException('class ' . $class . ' does not exist');
        }
        $menu = new $class(...$arguments);
        $this->menus[] = $menu;
        return $menu;
    }

    public function run(AdminMenu $parent_model = null)
    {
        foreach ($this->menus as $menu) {
            if ($parent_model) {
                $menu->setPid($parent_model->id);
                $menu->setLevel($parent_model->level + 1);
                $menu->setModule($parent_model->module);
            }
            $menu->setModule($this->module);
            $menu->toDB();
        }
    }

    public function setModule(string $module): MenuContainer
    {
        $this->module = $module;
        return $this;
    }
}

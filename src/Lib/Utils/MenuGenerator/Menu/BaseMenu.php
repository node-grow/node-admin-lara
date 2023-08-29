<?php

namespace NodeAdmin\Lib\Utils\MenuGenerator\Menu;

abstract class BaseMenu
{
    abstract public function toDB();

    protected array $data = [
        'name' => '',
        'title' => '',
        'url' => '',
        'sort' => 0,
        'pid' => 0,
        'level' => 0,
        'module' => '',
    ];

    public function setModule($module)
    {
        $this->data['module'] = $module;
        return $this;
    }

    public function setSort($sort)
    {
        $this->data['sort'] = $sort;
        return $this;
    }

    public function setPid($pid)
    {
        $this->data['pid'] = $pid;
        return $this;
    }

    public function setLevel($level)
    {
        $this->data['level'] = $level;
        return $this;
    }
}

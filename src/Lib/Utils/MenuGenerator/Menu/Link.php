<?php

namespace NodeAdmin\Lib\Utils\MenuGenerator\Menu;

use NodeAdmin\Models\AdminMenu;

class Link extends BaseMenu
{
    public function __construct($title, $name = '', $url = '')
    {
        $this->data['title'] = $title;
        if (!$name && !$url) {
            {
                throw new \InvalidArgumentException('You must provide a name or a url');
            }
        }
        $this->data['name'] = $name;
        $this->data['url'] = $url;
        $this->data['pid'] = 0;
    }

    public function toDB()
    {
        AdminMenu::query()->create([
            'title' => $this->data['title'],
            'level' => $this->data['level'],
            'pid' => $this->data['pid'],
            'status' => 1,
            'name' => $this->data['name'],
            'url' => $this->data['url'],
            'module' => $this->data['module'],
        ]);
    }
}

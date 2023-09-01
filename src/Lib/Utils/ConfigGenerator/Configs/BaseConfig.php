<?php

namespace NodeAdmin\Lib\Utils\ConfigGenerator\Configs;

use NodeAdmin\Models\Config;

abstract class BaseConfig
{
    protected string $type;

    protected string $name;
    protected string $title;
    protected mixed $value = null;
    protected string $tips = '';
    protected int $sort = 0;
    protected string $group = 'default';
    protected string $option = '';

    public function __construct($name, $title, $tips = '')
    {
        $this->name = $name;
        $this->title = $title;
        $this->tips = $tips;
    }

    public function setGroup(string $group)
    {
        $this->group = $group;
        return $this;
    }

    public function setSort(int $sort)
    {
        $this->sort = $sort;
        return $this;
    }

    public function setValue(mixed $value)
    {
        $this->value = $value;
        return $this;
    }

    public function setTips(string $tips)
    {
        $this->tips = $tips;
        return $this;
    }

    public function toDB()
    {
        return Config::query()->forceCreate([
            'name' => $this->name,
            'title' => $this->title,
            'type' => $this->type,
            'value' => $this->value,
            'tips' => $this->tips,
            'option' => $this->option,
            'status' => 1,
            'sort' => $this->sort,
            'group' => $this->group,
        ]);
    }

    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }
}

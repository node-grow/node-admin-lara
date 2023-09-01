<?php

namespace NodeAdmin\Lib\Utils\ConfigGenerator;

use Illuminate\Support\Str;
use NodeAdmin\Lib\Utils\ConfigGenerator\Configs\BaseConfig;
use NodeAdmin\Lib\Utils\ConfigGenerator\Configs\Image;
use NodeAdmin\Lib\Utils\ConfigGenerator\Configs\Select;
use NodeAdmin\Lib\Utils\ConfigGenerator\Configs\Text;
use NodeAdmin\Lib\Utils\ConfigGenerator\Configs\Textarea;
use NodeAdmin\Lib\Utils\ConfigGenerator\Configs\WangEditor;

/**
 * @method Text text($name, $title, $tips = '')
 * @method Textarea textarea($name, $title, $tips = '')
 * @method Select select($name, $title, $tips = '')
 * @method Image image($name, $title, $tips = '')
 * @method WangEditor wang_editor($name, $title, $tips = '')
 */
class ConfigContainer
{

    protected $group = 'default';

    protected $configs = [];

    public function setGroup(string $group)
    {
        $this->group = $group;
        return $this;
    }

    public function __call(string $name, array $arguments)
    {
        $class = 'NodeAdmin\\Lib\\Utils\\ConfigGenerator\\Configs\\' . Str::ucfirst(Str::camel($name));
        if (!class_exists($class)) {
            throw new \Exception('class not exists' . $class);
        }

        /** @var BaseConfig $config */
        $config = new $class(...$arguments);
        $config->setGroup($this->group);
        $this->configs[] = $config;
        return $config;
    }

    public function run()
    {
        foreach ($this->configs as $config) {
            $config->toDB();
        }
    }
}

<?php

namespace NodeAdmin\Lib\Utils\ConfigGenerator\Configs;

class Select extends BaseConfig
{
    protected string $type = 'select';

    public function setOptions(array $options)
    {
        $this->option = json_encode($options);
        return $this;
    }
}

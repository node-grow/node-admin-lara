<?php

namespace NodeAdmin\Lib\NodeContent\Form\Items\Table\Column;

use Illuminate\Support\Str;
use NodeAdmin\Lib\NodeContent\BaseContent;

abstract class BaseColumn extends BaseContent
{
    protected $type = '';

    protected $render_data = [
        'type' => '',
        'name' => '',
        'label' => '',
    ];

    protected function getType(): string
    {
        if ($this->type) {
            return $this->type;
        }
        return Str::snake(class_basename($this));
    }

    public function __construct($name, $label = '')
    {
        $this->render_data['type'] = $this->getType();
        $this->render_data['name'] = $name;
        $this->render_data['label'] = $label ?: $name;
        $this->render_data['column_option'] = [];
    }

    public function setDisabled(bool $disabled)
    {
        $this->render_data['disabled'] = $disabled;
        return $this;
    }

}

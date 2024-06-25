<?php

namespace NodeAdmin\Lib\NodeContent\Table\Columns\Filters;

use Illuminate\Support\Str;
use NodeAdmin\Lib\NodeContent\BaseContent;

abstract class BaseFilter extends BaseContent
{
    protected $type = '';
    protected $render_data = [
        'type' => '',
        'option' => []
    ];

    protected function getType(): string
    {
        if ($this->type) {
            return $this->type;
        }
        return Str::snake(class_basename($this));
    }

    public function __construct()
    {
        $this->render_data['type'] = $this->getType();
    }
}

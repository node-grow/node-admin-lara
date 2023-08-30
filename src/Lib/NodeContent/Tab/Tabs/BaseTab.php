<?php

namespace NodeAdmin\Lib\NodeContent\Tab\Tabs;

use Illuminate\Support\Str;
use NodeAdmin\Lib\NodeContent\BaseContent;

abstract class BaseTab extends BaseContent
{
    protected $type = '';

    protected function getType(): string
    {
        if ($this->type) {
            return $this->type;
        }
        return Str::snake(class_basename($this));
    }
}

<?php

namespace NodeAdmin\Lib\NodeContent\Table\Columns\Actions;

use Illuminate\Support\Str;
use NodeAdmin\Lib\NodeContent\BaseContent;
use NodeAdmin\Lib\NodeContent\Condition;
use NodeAdmin\Lib\NodeContent\Operation;

abstract class BaseRowAction extends BaseContent
{
    use Operation,Condition;

    protected $type='';

    protected $render_data=[
        'type' => '',
        'operation' => [],
        'action_option' => [],
        'condition' => null,
        'badge_key' => null,
    ];

    protected function getType(): string
    {
        if ($this->type) {
            return $this->type;
        }
        return Str::snake(class_basename($this));
    }

    public function setBadgeKey(string $badge_key)
    {
        $this->render_data['badge_key'] = $badge_key;
        return $this;
    }

    public function __construct()
    {
        $this->render_data['type'] = $this->getType();
    }
}

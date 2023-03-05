<?php

namespace NodeAdmin\Lib\NodeContent\Form\Actions;

use NodeAdmin\Lib\NodeContent\BaseContent;
use NodeAdmin\Lib\NodeContent\Condition;
use NodeAdmin\Lib\NodeContent\Operation;

abstract class BaseAction extends BaseContent
{
    use Operation, Condition;

    protected $render_data = [
        'type' => '',
        'action_option' => [],
        'operation' => null,
        'condition' => null,
    ];
}

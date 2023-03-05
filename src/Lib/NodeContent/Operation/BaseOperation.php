<?php

namespace NodeAdmin\Lib\NodeContent\Operation;

use NodeAdmin\Lib\NodeContent\BaseContent;

abstract class BaseOperation extends BaseContent
{
    protected $render_data=[
        'type'=>'',
        'operation_option'=>[],
    ];
}

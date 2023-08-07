<?php

namespace NodeAdmin\Lib\NodeContent\Operation;

class GotoAsA extends BaseOperation
{
    public function __construct($url, $target = '_blank')
    {
        $this->render_data['type'] = 'goto_as_a';
        $this->render_data['operation_option']['url'] = $url;
        $this->render_data['operation_option']['target'] = $target;
    }
}

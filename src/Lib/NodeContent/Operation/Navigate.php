<?php

namespace NodeAdmin\Lib\NodeContent\Operation;

class Navigate extends BaseOperation
{
    public function __construct($url)
    {
        $this->render_data['type'] = 'navigate';
        $this->render_data['operation_option']['url'] = $url;
    }
}

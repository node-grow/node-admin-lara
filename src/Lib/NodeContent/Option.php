<?php

namespace NodeAdmin\Lib\NodeContent;


class Option extends BaseContent
{
    public function __construct($value,$label)
    {
        $this->render_data=[
            'label'=>$label,
            'value'=>$value,
        ];
    }
}

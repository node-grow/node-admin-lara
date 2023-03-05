<?php

namespace NodeAdmin\Lib\NodeContent;

trait Condition
{
    public function setCondition($key,$operator,$value){
        $this->render_data['condition']=[
            'key'=>$key,
            'operator'=>$operator,
            'value'=>$value,
        ];
        return $this;
    }
}

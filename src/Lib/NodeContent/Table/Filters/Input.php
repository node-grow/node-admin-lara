<?php

namespace NodeAdmin\Lib\NodeContent\Table\Filters;

class Input extends BaseFilter
{
    public function setPlaceholder($placeholder){
        $this->render_data['filter_option']['placeholder']=$placeholder;
        return $this;
    }
}

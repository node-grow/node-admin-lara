<?php

namespace NodeAdmin\Lib\NodeContent\Table\Filters;

class Custom extends BaseFilter
{

    public function setUrl($url){
        $this->render_data['filter_option']['url']=$url;
        return $this;
    }

}

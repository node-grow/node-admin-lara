<?php

namespace NodeAdmin\Lib\NodeContent\Form\Items;

class Custom extends BaseItem
{
    public function setUrl($url){
        $this->render_data['item_option']['url']=$url;
        return $this;
    }

    public function addItemOption($key,$value){
        $this->render_data['item_option'][$key]=$value;
        return $this;
    }
}

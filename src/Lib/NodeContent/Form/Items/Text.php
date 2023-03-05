<?php

namespace NodeAdmin\Lib\NodeContent\Form\Items;

class Text extends BaseItem
{
    public function setText(string $text){
        $this->render_data['item_option']['text']=$text;
        return $this;
    }
}

<?php

namespace NodeAdmin\Lib\NodeContent\Form\Items;

class Date extends BaseItem
{

    public function setPlaceholder($placeholder){
        $this->render_data['item_option']['placeholder'] = $placeholder;
        return $this;
    }

    public function setShowTime($is_show = false){
        $this->render_data['item_option']['show_time'] = $is_show;
        return $this;
    }

    public function setPicker($picker){
        $this->render_data['item_option']['picker'] = $picker;
        return $this;
    }

    public function setValueFormat($format){
        $this->render_data['item_option']['value_format'] = $format;
        return $this;
    }
}

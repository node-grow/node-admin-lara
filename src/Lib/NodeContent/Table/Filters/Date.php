<?php

namespace NodeAdmin\Lib\NodeContent\Table\Filters;

class Date extends BaseFilter
{
    public function __construct($name, $title = '')
    {
        parent::__construct($name, $title);
        $this->setFilterOnChange(true);
    }

    public function setPlaceholder($placeholder){
        $this->render_data['filter_option']['placeholder'] = $placeholder;
        return $this;
    }

    public function setShowTime($is_show = false){
        $this->render_data['filter_option']['show_time'] = $is_show;
        return $this;
    }

    public function setPicker($picker){
        $this->render_data['filter_option']['picker'] = $picker;
        return $this;
    }

    public function setValueFormat($format){
        $this->render_data['filter_option']['value_format'] = $format;
        return $this;
    }
}

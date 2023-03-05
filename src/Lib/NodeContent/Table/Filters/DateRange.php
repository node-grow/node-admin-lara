<?php

namespace NodeAdmin\Lib\NodeContent\Table\Filters;

class DateRange extends Date
{

    public function __construct($name, $title = '')
    {
        parent::__construct($name, $title);
        $this->setPlaceholder(['请选择开始时间','请选择结束时间']);
        $this->setFilterOnChange(true);
    }
}

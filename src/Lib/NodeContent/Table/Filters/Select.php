<?php

namespace NodeAdmin\Lib\NodeContent\Table\Filters;


use NodeAdmin\Lib\NodeContent\Traits\HasOptions;

class Select extends BaseFilter
{
    use HasOptions;

    protected function getOptionName(): string
    {
        return 'filter_option';
    }

    public function __construct($name, $title = '')
    {
        parent::__construct($name, $title);
        $this->setFilterOnChange(true);
    }

    public function setPlaceholder($placeholder){
        $this->render_data['filter_option']['placeholder']=$placeholder;
        return $this;
    }

    public function setSearchAble(bool $searchable){
        $this->render_data['filter_option']['searchable']=$searchable;
        return $this;
    }

    public function setSearchUrl(string $url){
        $this->setSearchAble(true);
        $this->render_data['filter_option']['search_url']=$url;
        return $this;
    }
}

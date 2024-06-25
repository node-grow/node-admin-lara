<?php

namespace NodeAdmin\Lib\NodeContent\Table\Columns;

use Illuminate\Support\Str;
use NodeAdmin\Lib\NodeContent\BaseContent;
use NodeAdmin\Lib\NodeContent\Table\Columns\Filters\BaseFilter;

abstract class BaseColumn extends BaseContent
{
    protected $type='';
    protected $render_data=[
        'type'=>'',
        'name'=>'',
        'title'=>'',
        'sortable' => false,
        'column_option'=>[],
        'filter' => null,
    ];

    protected function getType():string{
        if ($this->type){
            return $this->type;
        }
        return Str::snake(class_basename($this));
    }

    public function __construct($name,$title='')
    {
        $this->render_data['type']=$this->getType();
        $this->render_data['name']=$name;
        $this->render_data['title']=$title?:$name;
    }

    public function sortable(bool $sortable)
    {
        $this->render_data['sortable'] = $sortable;
        return $this;
    }

    public function setFilter(BaseFilter $filter)
    {
        $this->render_data['filter'] = $filter;
        return $this;
    }
}

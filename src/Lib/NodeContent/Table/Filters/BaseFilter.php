<?php

namespace NodeAdmin\Lib\NodeContent\Table\Filters;

use Illuminate\Support\Str;
use NodeAdmin\Lib\NodeContent\BaseContent;

abstract class BaseFilter extends BaseContent
{
    protected $type='';

    protected $render_data=[
        "type"=>"",
        "name"=>"",
        "title"=>"",
        "filter_on_change"=>false,
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
        $this->render_data['filter_option']=[];

        if (method_exists($this,'setPlaceholder')){
            $this->setPlaceholder($title?:$name);
        }
    }

    public function setFilterOnChange($filter_on_change){
        $this->render_data['filter_on_change']=$filter_on_change;
        return $this;
    }
}

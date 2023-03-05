<?php

namespace NodeAdmin\Lib\NodeContent\Table\Columns;

use Illuminate\Support\Str;
use NodeAdmin\Lib\NodeContent\BaseContent;

abstract class BaseColumn extends BaseContent
{
    protected $type='';
    protected $render_data=[
        'type'=>'',
        'name'=>'',
        'title'=>'',
        'column_option'=>[],
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
}

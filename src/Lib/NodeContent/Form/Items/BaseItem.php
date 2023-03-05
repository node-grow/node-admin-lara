<?php

namespace NodeAdmin\Lib\NodeContent\Form\Items;

use Illuminate\Support\Str;
use NodeAdmin\Lib\NodeContent\BaseContent;
use NodeAdmin\Lib\NodeContent\Condition;

abstract class BaseItem extends BaseContent
{
    use Condition;

    protected $type='';

    protected $render_data=[
        'type'=>'',
        'name'=>'',
        'label'=>'',
        'tips'=>'',
        'condition'=>null,
    ];

    protected function getType():string{
        if ($this->type){
            return $this->type;
        }
        return Str::snake(class_basename($this));
    }

    public function __construct($name,$label='',$tips='')
    {
        $this->render_data['type']=$this->getType();
        $this->render_data['name']=$name;
        $this->render_data['label']=$label?:$name;
        $this->render_data['tips']=$tips;
        $this->render_data['condition']=null;
        $this->render_data['item_option']=[];
    }

    public function setDisabled(bool $disabled){
        $this->render_data['disabled']=$disabled;
        return $this;
    }
}

<?php

namespace NodeAdmin\Lib\NodeContent\Table\Actions;

use Illuminate\Support\Str;
use NodeAdmin\Lib\NodeContent\BaseContent;
use NodeAdmin\Lib\NodeContent\Operation;

abstract class BaseAction extends BaseContent
{
    use Operation;
    protected $type='';

    protected $render_data=[
        'type'=>'',
        'operation'=>null,
        'action_option'=>[],
        'badge'=>0,
    ];

    protected function getType():string{
        if ($this->type){
            return $this->type;
        }
        return Str::snake(class_basename($this));
    }

    public function __construct($badge=0)
    {
        $this->render_data['type']=$this->getType();
        $this->render_data['badge']=$badge;
    }
}

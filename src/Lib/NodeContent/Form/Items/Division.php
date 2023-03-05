<?php

namespace NodeAdmin\Lib\NodeContent\Form\Items;


use App\Http\Controllers\Admin\DivisionsController;

class Division extends BaseItem
{
    public function __construct($name, $label = '', $tips = '')
    {
        parent::__construct($name, $label, $tips);
        $this->setUrl(action([DivisionsController::class,'show'],['division'=>'__id__']))
            ->setLevel(3);
    }

    public function setUrl(string $url){
        $this->render_data['item_option']['url']=$url;
        return $this;
    }

    public function setLevel(int $level){
        $this->render_data['item_option']['level']=$level;
        return $this;
    }
}

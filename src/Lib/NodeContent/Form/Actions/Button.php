<?php

namespace NodeAdmin\Lib\NodeContent\Form\Actions;


class Button extends BaseAction
{
    public function __construct($title='',$btn_type='')
    {
        $this->render_data['type']='button';
        $this->render_data['action_option']['title']=$title?:'按钮';
        $this->render_data['action_option']['btn_type']=$btn_type?:'primary';
        $this->render_data['operation']=null;
    }

    public function setStyle(array $style){
        $this->render_data['action_option']['style']=$style;
        return $this;
    }
}

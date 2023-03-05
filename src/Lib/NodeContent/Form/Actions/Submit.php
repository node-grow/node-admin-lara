<?php

namespace NodeAdmin\Lib\NodeContent\Form\Actions;


class Submit extends Button
{
    public function __construct($title='',$btn_type='')
    {
        parent::__construct($title,$btn_type);

        $this->render_data['type']='submit';
        $this->render_data['action_option']['title']=$title?:'提交';
        $this->render_data['action_option']['btn_type']=$btn_type?:'primary';
        $this->render_data['operation']=null;
    }
}

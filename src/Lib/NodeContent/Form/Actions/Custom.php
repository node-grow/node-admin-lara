<?php

namespace NodeAdmin\Lib\NodeContent\Form\Actions;


class Custom extends BaseAction
{
    public function __construct($url)
    {
        $this->render_data['type']='custom';
        $this->render_data['action_option']['url']=$url;
        $this->render_data['operation']=null;
    }
}

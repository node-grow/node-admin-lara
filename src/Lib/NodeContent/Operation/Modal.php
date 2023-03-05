<?php

namespace NodeAdmin\Lib\NodeContent\Operation;

class Modal extends Request
{
    public function __construct($url,$title,$type='node_content')
    {
        parent::__construct($url,'get');
        $this->render_data['type']='modal';
        $this->render_data['operation_option']['url']=$url;
        $this->render_data['operation_option']['title']=$title;
        $this->render_data['operation_option']['type']=$type;
    }
}

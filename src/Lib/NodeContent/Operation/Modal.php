<?php

namespace NodeAdmin\Lib\NodeContent\Operation;

use NodeAdmin\Lib\NodeContent\Traits\PreloadNodeData;

class Modal extends Request
{
    use PreloadNodeData;

    public function __construct($url,$title,$type='node_content')
    {
        parent::__construct($url,'get');
        $this->render_data['type']='modal';
        $this->render_data['operation_option']['url']=$url;
        $this->render_data['operation_option']['title']=$title;
        $this->render_data['operation_option']['type']=$type;
    }

    protected function setNodeDataToRender()
    {
        $this->render_data['operation_option']['node_data'] = $this->node_data;
    }
}

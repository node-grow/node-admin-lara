<?php

namespace NodeAdmin\Lib\NodeContent\Operation;

class AddTab extends Request
{
    public function __construct($url,$title,$closable=true,$type='node_content')
    {
        parent::__construct($url,'get');
        $this->render_data['type']='add_tab';
        $this->render_data['operation_option']['url']=$url;
        $this->render_data['operation_option']['title']=$title;
        $this->render_data['operation_option']['closable']=$closable;
        $this->render_data['operation_option']['type']=$type;
    }
}

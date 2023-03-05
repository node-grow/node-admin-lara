<?php

namespace NodeAdmin\Lib\NodeContent\Table\Actions;


class Custom extends BaseAction
{
    public function setUrl($url){
        $this->render_data['action_option']['url']=$url;
        return $this;
    }
}

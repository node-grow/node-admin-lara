<?php

namespace NodeAdmin\Lib\NodeContent\Table\Actions;


class Button extends BaseAction
{
    protected $type='button';

    public function setTitle($title){
        $this->render_data['action_option']['title']=$title;
        return $this;
    }

    public function setForSelected($for_selected){
        $this->render_data['action_option']['for_selected']=$for_selected;
        return $this;
    }

    public function setStyle(array $style){
        $this->render_data['action_option']['style']=$style;
        return $this;
    }
}

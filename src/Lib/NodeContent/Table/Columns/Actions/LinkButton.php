<?php

namespace NodeAdmin\Lib\NodeContent\Table\Columns\Actions;

class LinkButton extends BaseRowAction
{
    protected $type='link_button';


    public function setDanger(bool $is_danger){
        $this->render_data['action_option']['danger']=$is_danger;
        return $this;
    }

    public function setTitle(string $title){
        $this->render_data['action_option']['title']=$title;
        return $this;
    }

    public function setStyle(array $style){
        $this->render_data['action_option']['style']=$style;
        return $this;
    }
}

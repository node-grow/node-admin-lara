<?php

namespace NodeAdmin\Lib\NodeContent\Form\Items;

class Input extends BaseItem
{
    use HasOnlyShow;

    public function setPlaceholder($placeholder){
        $this->render_data['item_option']['placeholder'] = $placeholder;
        return $this;
    }

    public function transformOnlyShow($form_data)
    {
        $this->render_data['type']='text';
        $this->render_data['item_option']=[
            'text'=>$form_data[$this->render_data['name']]
        ];
        $this->render_data['name']='';
    }
}

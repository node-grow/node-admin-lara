<?php

namespace NodeAdmin\Lib\NodeContent\Form\Items;

class Iconfont extends Select
{
    public function __construct($name, $label = '', $tips = '')
    {
        parent::__construct($name, $label, $tips);

        $this->render_data['item_option']['options']=collect(
            \NodeAdmin\Lib\NodeContent\Iconfont::getSymbols(config('admin.iconfont_symbol_url'))
        )->map(function ($icon){
            return [
                'label'=>$icon,
                'value'=>$icon,
            ];
        });

        $this->setSearchable(true);
    }
}

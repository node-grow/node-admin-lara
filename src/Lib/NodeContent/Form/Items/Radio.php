<?php

namespace NodeAdmin\Lib\NodeContent\Form\Items;

use NodeAdmin\Lib\NodeContent\Traits\HasOptions;

class Radio extends BaseItem
{
    use HasOptions;

    protected function  getOptionName():string{
        return 'item_option';
    }

}

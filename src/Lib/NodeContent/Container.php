<?php

namespace NodeAdmin\Lib\NodeContent;

use NodeAdmin\Lib\NodeContent\Traits\AutoCallByType;

abstract class Container extends BaseContent
{
    use AutoCallByType;

    protected $render_data=[];

}

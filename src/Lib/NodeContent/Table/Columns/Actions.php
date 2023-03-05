<?php

namespace NodeAdmin\Lib\NodeContent\Table\Columns;

use NodeAdmin\Lib\NodeContent\Table\Columns\Actions\ActionsContainer;

class Actions extends BaseColumn
{
    public function __construct($name, $title = '操作')
    {
        parent::__construct($name, $title);
    }

    public function setActions(\Closure $fn){
        $container=app(ActionsContainer::class);
        $fn($container);
        $this->render_data['column_option']['actions']=$container;
        return $this;
    }
}

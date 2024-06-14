<?php

namespace NodeAdmin\Lib\NodeContent\Form\Items\Table;

use NodeAdmin\Lib\NodeContent\Container;
use NodeAdmin\Lib\NodeContent\Form\Items\Table\Column\BaseColumn;
use NodeAdmin\Lib\NodeContent\Form\Items\Table\Column\Input;
use NodeAdmin\Lib\NodeContent\Form\Items\Table\Column\Select;

/**
 * @method Input input($name, $label)
 * @method Select select($name, $label)
 */
class ColumnsContainer extends Container
{

    protected function getAutoCallNamespace()
    {
        return 'NodeAdmin\Lib\NodeContent\Form\Items\Table\Column';
    }

    protected function getAutoCallMethod()
    {
        return 'addColumn';
    }

    public function addColumn(BaseColumn $column)
    {
        $this->render_data[] = $column;
    }
}

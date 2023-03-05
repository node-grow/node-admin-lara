<?php

namespace NodeAdmin\Lib\NodeContent\Table;

use NodeAdmin\Lib\NodeContent\Container;
use NodeAdmin\Lib\NodeContent\Table\Columns\Actions;
use NodeAdmin\Lib\NodeContent\Table\Columns\BaseColumn;
use NodeAdmin\Lib\NodeContent\Table\Columns\Images;
use NodeAdmin\Lib\NodeContent\Table\Columns\Input;
use NodeAdmin\Lib\NodeContent\Table\Columns\SwitchCase;
use NodeAdmin\Lib\NodeContent\Table\Columns\Text;

/**
 * @method Text text($name,$title='')
 * @method Actions actions($name,$title='')
 * @method Images images($name, $title='')
 * @method Input input($name, $title='')
 * @method SwitchCase switch_case($name, $title='')
 */
class ColumnsContainer extends Container
{

    protected $render_data=[];

    public function addColumn(BaseColumn $column){
        $this->render_data[]=$column;
    }

    protected function getAutoCallNamespace()
    {
        return 'NodeAdmin\Lib\NodeContent\Table\Columns';
    }

    protected function getAutoCallMethod()
    {
        return 'addColumn';
    }
}

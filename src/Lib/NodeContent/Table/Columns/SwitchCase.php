<?php

namespace NodeAdmin\Lib\NodeContent\Table\Columns;

use NodeAdmin\Lib\NodeContent\Operation;
use NodeAdmin\Lib\NodeContent\Operation\BaseOperation;

class SwitchCase extends BaseColumn
{
    use Operation;

    protected $type='switch';

    public function setOperation(BaseOperation $operation){
        $this->render_data['column_option']['operation']=$operation;
    }
}

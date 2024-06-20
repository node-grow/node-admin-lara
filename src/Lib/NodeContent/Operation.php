<?php

namespace NodeAdmin\Lib\NodeContent;

use NodeAdmin\Lib\NodeContent\Operation\AddTab;
use NodeAdmin\Lib\NodeContent\Operation\BaseOperation;
use NodeAdmin\Lib\NodeContent\Operation\GotoAsA;
use NodeAdmin\Lib\NodeContent\Operation\Modal;
use NodeAdmin\Lib\NodeContent\Operation\Navigate;
use NodeAdmin\Lib\NodeContent\Operation\Request;
use NodeAdmin\Lib\NodeContent\Traits\AutoCallByType;

/**
 * @method AddTab addTab($url, $title, $closable = true, $type = 'node_content')
 * @method Modal modal($url, $title, $type = 'node_content')
 * @method Request request($url, $method, $body = null)
 * @method GotoAsA gotoAsA($url, $target = '_blank')
 * @method Navigate navigate($url)
 */
trait Operation
{
    use AutoCallByType;

    public function setOperation(BaseOperation $operation){
        $this->render_data['operation']=$operation;
    }


    protected function getAutoCallNamespace()
    {
        return 'NodeAdmin\Lib\NodeContent\Operation';
    }

    protected function getAutoCallMethod()
    {
        return 'setOperation';
    }
}

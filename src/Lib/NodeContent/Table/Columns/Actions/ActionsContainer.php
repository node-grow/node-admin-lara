<?php

namespace NodeAdmin\Lib\NodeContent\Table\Columns\Actions;

use NodeAdmin\Lib\NodeContent\Container;

/**
 * @method Edit edit()
 * @method Delete delete()
 * @method Forbid forbid()
 * @method Resume resume()
 * @method LinkButton linkButton()
 */
class ActionsContainer extends Container
{
    protected $render_data=[];

    public function addAction(BaseRowAction $action){
        $this->render_data[]=$action;
    }

    protected function getAutoCallNamespace()
    {
        return 'NodeAdmin\Lib\NodeContent\Table\Columns\Actions';
    }

    protected function getAutoCallMethod()
    {
        return 'addAction';
    }
}

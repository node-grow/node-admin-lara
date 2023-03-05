<?php

namespace NodeAdmin\Lib\NodeContent\Table;

use NodeAdmin\Lib\NodeContent\Container;
use NodeAdmin\Lib\NodeContent\Table\Actions\BaseAction;
use NodeAdmin\Lib\NodeContent\Table\Actions\Button;
use NodeAdmin\Lib\NodeContent\Table\Actions\Create;
use NodeAdmin\Lib\NodeContent\Table\Actions\Custom;

/**
 * @method Button button($badge=0)
 * @method Create create($badge=0)
 * @method Custom custom($badge=0)
 */

class ActionsContainer extends Container
{

    protected $render_data=[];

    public function addAction(BaseAction $action){
        $this->render_data[]=$action;
    }

    protected function getAutoCallNamespace()
    {
        return 'NodeAdmin\Lib\NodeContent\Table\Actions';
    }

    protected function getAutoCallMethod()
    {
        return 'addAction';
    }
}

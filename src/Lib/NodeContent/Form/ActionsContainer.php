<?php

namespace NodeAdmin\Lib\NodeContent\Form;

use NodeAdmin\Lib\NodeContent\Container;
use NodeAdmin\Lib\NodeContent\Form\Actions\BaseAction;
use NodeAdmin\Lib\NodeContent\Form\Actions\Button;
use NodeAdmin\Lib\NodeContent\Form\Actions\Submit;

/**
 * @method Submit submit($title='',$btn_type='')
 * @method Button button($title='',$btn_type='')
 */

class ActionsContainer extends Container
{

    protected $render_data=[];

    public function addAction(BaseAction $action){
        $this->render_data[]=$action;
    }

    protected function getAutoCallNamespace()
    {
        return 'NodeAdmin\Lib\NodeContent\Form\Actions';
    }

    protected function getAutoCallMethod()
    {
        return 'addAction';
    }
}

<?php

namespace NodeAdmin\Lib\NodeContent\Table\Columns\Actions;

use Illuminate\Support\Facades\Route;

class Delete extends LinkButton
{
    public function __construct()
    {
        parent::__construct();
        $this->setTitle('删除');
        $this->setDanger(true);
    }

    public function defaultOperation($route_param,$confirm='确认删除？'){
        $controller=Route::current()->getControllerClass();
        $this->request(action([$controller,'destroy'],[$route_param=>'__id__']),'delete')
            ->setConfirm($confirm);
        return $this;
    }
}

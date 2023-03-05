<?php

namespace NodeAdmin\Lib\NodeContent\Table\Columns\Actions;

use Illuminate\Support\Facades\Route;

class Edit extends LinkButton
{
    public function __construct()
    {
        parent::__construct();
        $this->setTitle('编辑');
    }

    public function defaultOperation($route_param,$modal_title='编辑'){
        $controller=Route::current()->getControllerClass();
        $this->modal(action([$controller,'edit'],[$route_param=>'__id__']),$modal_title);
        return $this;
    }
}

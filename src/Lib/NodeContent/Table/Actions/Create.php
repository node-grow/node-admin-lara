<?php

namespace NodeAdmin\Lib\NodeContent\Table\Actions;

use Illuminate\Support\Facades\Route;

class Create extends Button
{
    public function __construct($badge = 0)
    {
        parent::__construct($badge);
        $this->setTitle('新增');
    }

    public function defaultOperation($modal_title='新增'){
        $controller=Route::current()->getControllerClass();
        $this->modal(action([$controller,'create']),$modal_title);
        return $this;
    }
}

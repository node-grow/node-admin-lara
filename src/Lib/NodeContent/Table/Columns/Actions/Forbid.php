<?php

namespace NodeAdmin\Lib\NodeContent\Table\Columns\Actions;

use Illuminate\Support\Facades\Route;

class Forbid extends LinkButton
{
    public function __construct()
    {
        parent::__construct();
        $this->setTitle('禁用');
        $this->setStyle([
            'color'=>'#E6A23C'
        ]);
    }

    public function defaultOperation($route_param,$status_key='status'){
        $this->setCondition($status_key,'eq',1);
        $controller=Route::current()->getControllerClass();
        $this->request(action([$controller,'forbid'],[$route_param=>'__id__']),'put');
        return $this;
    }
}

<?php

namespace NodeAdmin\Lib\NodeContent\Table\Columns\Actions;

use Illuminate\Support\Facades\Route;

class Resume extends LinkButton
{
    public function __construct()
    {
        parent::__construct();
        $this->setTitle('启用');
        $this->setStyle([
            'color'=>'#67C23A'
        ]);
    }

    public function defaultOperation($route_param,$status_key='status'){
        $this->setCondition($status_key,'eq',0);
        $controller=Route::current()->getControllerClass();
        $this->request(action([$controller,'resume'],[$route_param=>'__id__']),'put');
        return $this;
    }
}

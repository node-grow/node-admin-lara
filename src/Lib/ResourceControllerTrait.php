<?php

namespace NodeAdmin\Lib;

use Illuminate\Http\Request;
use NodeAdmin\Lib\NodeContent\Table;

trait ResourceControllerTrait
{
    use TableDataListTrait;

    abstract public function table(Table $table);
    abstract public function dataList();

    public function index(Request $request,Table $table){
        if (!$request->query->get('list')){
            app()->call([$this,'table'],['table'=>$table]);
            if (!$table->getDataUrl()){
                $table->setDataUrl(action([get_class($this),'index'],['list'=>true]));
            }
            return $table;
        }

        return app()->call([$this,'dataList']);

    }


}

<?php

namespace NodeAdmin\Lib;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use NodeAdmin\Lib\NodeContent\Table;

trait ResourceControllerTrait
{
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

    protected function transformDataList($data_list,LengthAwarePaginator $pagination=null){
        if ($data_list instanceof LengthAwarePaginator){
            return [
                'data_list' => $data_list->items(),
                'pagination' => [
                    'total' => $data_list->total(),
                    'page_size' => $data_list->perPage(),
                    'current' => $data_list->currentPage(),
                ]
            ];
        }

        if (method_exists($data_list, 'toArray')) {
            $data_list = $data_list->toArray();
        }
        $res = ['data_list' => $data_list];
        if ($pagination) {
            $res['pagination'] = [
                'total' => $pagination->total(),
                'page_size' => $pagination->perPage(),
                'current' => $pagination->currentPage(),
            ];
        }
        return $res;
    }


}

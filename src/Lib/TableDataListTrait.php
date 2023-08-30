<?php

namespace NodeAdmin\Lib;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait TableDataListTrait
{
    protected function transformDataList($data_list, LengthAwarePaginator $pagination = null)
    {
        if ($data_list instanceof LengthAwarePaginator) {
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

<?php

namespace NodeAdmin\Http\Controllers\Admin;


use ChinaDivisions\Division;
use ChinaDivisions\Exceptions\ResponseException;
use NodeAdmin\Exceptions\NodeException;
use NodeAdmin\Lib\ResourceController;

class DivisionsController extends ResourceController
{
    protected $should_cached=true;

    public function index()
    {
        return $this->show();
    }

    public function show(int $division=1)
    {
        if ($this->should_cached && $res=cache()->get('division_cache_'.$division)){
            return $res;
        }
        try {
            $div=new Division($division);
            $res=$this->handleDivision($div);
            $res['children']=collect($div->children())->map(function ($division){
                return $this->handleDivision($division);
            });
            cache()->set('division_cache_'.$division,$res,3600);
            return $res;
        }catch (ResponseException $e){
            throw new NodeException('地区获取失败：'.$e->getMessage());
        }
    }

    protected function handleDivision(Division $division){
        $division=$division->self();
        return [
            'id'=>$division['divisionId'],
            'name'=>$division['divisionName'],
            'level'=>$division['divisionLevel'],
            'parent_id'=>$division['parentId'],
        ];
    }
}

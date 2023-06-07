<?php

namespace NodeAdmin\Http\Controllers\Admin;


use NodeAdmin\Exceptions\NodeException;
use NodeAdmin\Lib\ResourceController;
use NodeAdmin\Services\DistrictService;

class DivisionsController extends ResourceController
{
    protected $should_cached=true;

    public function index()
    {
        return $this->show();
    }

    public function show(int $division=1)
    {
        $service = new DistrictService();
        try {
            $district = $service->findById($division);
            $district->set('children', array_map(function (DistrictService\District $district) {
                return $district->toArray();
            }, $service->children($division)));
            return $district->toArray();
        } catch (\Exception $e) {
            throw new NodeException('地区获取失败：' . $e->getMessage());
        }
    }
}

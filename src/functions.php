<?php

use ChinaDivisions\Division;
use Illuminate\Contracts\Auth\Authenticatable;
use NodeAdmin\Models\Files;

if (!function_exists('getFileUrl')) {
    function getFileUrl($fid, $options = null)
    {
        return \NodeAdmin\Models\Files::query()->find($fid)->getUrl($options);
    }
}

if (!function_exists('handleSaveFile')) {
    function handleSaveFile(array $file): string
    {
        $id = array_column($file, 'id');
        $value = implode(',', $id);
        return $value;
    }
}

if (!function_exists('treeForCollection')) {
    /**
     * @param \Illuminate\Support\Collection $collection
     * @param $parent_key
     * @param $self_key
     * @param $children_key
     * @param $parent
     * @return \Illuminate\Support\Collection
     */
    function treeForCollection(\Illuminate\Support\Collection $collection, $parent_key = 'pid', $self_key = 'id', $children_key = 'children', $parent = 0)
    {
        $roots = $collection->where($parent_key, $parent)->collect()->values();
        return $roots->map(function ($item) use ($parent_key, $children_key, $self_key, $collection) {
            $children = treeForCollection($collection, $parent_key, $self_key, $children_key, $item->$self_key);
            if ($children->first()) {
                $item->$children_key = $children;
            }
            return $item;
        })->collect()->values();
    }
}

/**
 * 获取passport登录的用户
 * @param $guard
 * @return Authenticatable|null
 */
if (!function_exists('getPpLoginUser')) {
    function getPpLoginUser($guard): ?Authenticatable
    {
        return auth()->guard($guard)->user();
    }
}

if (!function_exists('getSiteProtocol')) {
    function getSiteProtocol()
    {
        return $_SERVER['REQUEST_SCHEME'];
    }
}

if (!function_exists('getFullDomain')) {
    function getFullDomain(): string
    {
        return getSiteProtocol() . '://' . $_SERVER['HTTP_HOST'];
    }
}

if (!function_exists('getFilesValueById')) {
    function getFilesValueByIds($ids, $options = null)
    {
        if (!$ids) {
            return [];
        }
        if (is_string($ids) || is_numeric($ids)) {
            $ids = explode(',', $ids);
        }
        return array_map(fn($id) => [
            'id' => $id,
            'url' => getFileUrl($id, $options),
            'name' => Files::query()->find($id)->filename ?: ''
        ], $ids);
    }
}

if (!function_exists('getDivisionNameByIds')) {
    function getDivisionNameByIds(array $ids, $separator = ','): string
    {
        $id = last($ids);
        $name = cache()->get('division_name_by_id_' . $id, '');
        if ($name) {
            return $name;
        }
        $division = new Division($id);
        $res = join($separator, array_map(fn(Division $division) => $division->self()['divisionAbbName'], $division->ancestors()));
        cache()->put('division_name_by_id_' . $id, $res, 600);
        return $res;
    }
}

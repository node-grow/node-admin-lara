<?php

namespace NodeAdmin\Services;

use ChinaDivisions\Division;
use Illuminate\Support\Facades\DB;
use NodeAdmin\Exceptions\NodeException;
use NodeAdmin\Services\DistrictService\District;

class DistrictService
{
    protected static $by_db = false;

    public function __construct()
    {
        try {
            if (DB::table('districts')->exists()) {
                self::$by_db = true;
            }
        } catch (\Exception $e) {
            self::$by_db = false;
        }
    }

    public function findById($id)
    {
        if (self::$by_db) {
            $district = DB::table('districts')->find($id);
            return new District([
                'id' => $district->id,
                'name' => $district->name,
                'level' => $district->level,
                'parent_id' => $district->parent_id,
            ]);
        }
        $division = new Division($id);
        $division = $division->self();
        return new District([
            'id' => $division['divisionId'],
            'name' => $division['divisionName'],
            'level' => $division['divisionLevel'],
            'parent_id' => $division['parentId'],
        ]);
    }

    public function children($id)
    {
        if (self::$by_db) {
            return array_map(function ($district) {
                return new District([
                    'id' => $district->id,
                    'name' => $district->name,
                    'abb_name' => $district->abb_name,
                    'level' => $district->level,
                    'parent_id' => $district->parent_id,
                ]);
            }, DB::table('districts')->where('parent_id', $id)->get()->toArray());
        }
        $division = new Division($id);
        return array_map(function (Division $division) {
            $division = $division->self();
            return new District([
                'id' => $division['divisionId'],
                'name' => $division['divisionName'],
                'abb_name' => $division['divisionAbbName'],
                'level' => $division['divisionLevel'],
                'parent_id' => $division['parentId'],
            ]);
        }, $division->children());
    }

    public function getNamesByIds(array $ids, $separator = ',')
    {
        if (self::$by_db) {
            $res = '';
            foreach ($ids as $id) {
                $district = DB::table('districts')->find($id);
                $res .= ',' . $district->abb_name;
            }
            return trim($res, $separator);
        }

        $id = last($ids);
        $division = new Division($id);
        $res = join($separator, array_map(fn(Division $division) => $division->self()['divisionAbbName'], $division->ancestors()));
        return $res;
    }

    public function getIdsByNames(array $names)
    {
        if (!self::$by_db) {
            throw new NodeException('You must run "php artisan node-admin:distinct-by-db" first');
        }
        $ids = [];
        foreach ($names as $index => $name) {
            $district = DB::table('districts')->where('name', 'like', $name . '%')->where('level', $index + 1)->first();
            if ($district) {
                $ids[] = $district->id;
            }
        }
        return $ids;

    }
}

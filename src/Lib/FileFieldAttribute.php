<?php

namespace NodeAdmin\Lib;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Collection;
use NodeAdmin\Models\Files;

class FileFieldAttribute extends Attribute
{
    public function getGet()
    {
        return $this->get;
    }

    public function getSet()
    {
        return $this->set;
    }

    public function __construct(bool $isMultiple = false)
    {
        parent::__construct(
            get: fn($value) => $isMultiple ?
                Files::query()->whereIn('id', $value ? explode(',', $value) : [])->get() :
                Files::query()->where('id', $value)->first(),
            set: function ($file_list) use ($isMultiple) {
                if ($file_list instanceof Files) {
                    return $file_list->id;
                }
                if ($isMultiple) {
                    if ($file_list instanceof Collection){
                        return $file_list->map(fn($file)=>$file['id'])->join(',');
                    }
                    return implode(',', array_map(fn($file) => $file['id'], $file_list));
                }
                if (!$file_list) {
                    return $file_list;
                }
                if (is_array($file_list)) {
                    if (array_values($file_list) !== $file_list) {
                        $file_list = [$file_list];
                    }
                    if (!$file_list[0]) {
                        return $file_list[0];
                    }
                    return $file_list[0]['id'];
                }
                return $file_list;
            }
        );
    }
}

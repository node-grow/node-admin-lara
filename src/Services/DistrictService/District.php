<?php

namespace NodeAdmin\Services\DistrictService;

use Illuminate\Contracts\Support\Arrayable;

class District implements Arrayable
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function toArray()
    {
        return $this->data;
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }
}

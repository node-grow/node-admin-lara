<?php

namespace NodeAdmin\Lib\NodeContent;


use Illuminate\Contracts\Support\Arrayable;

abstract class BaseContent implements Arrayable
{
    protected $render_data=[];

    public function toArray():array
    {
        return $this->transform($this->render_data);
    }

    protected function transform($data){
        if (is_array($data)){
            foreach ($data as &$item) {
                $item=$this->transform($item);
            }
            return $data;
        }
        if ($data instanceof BaseContent){
            return $data->toArray();
        }

        return $data;
    }
}

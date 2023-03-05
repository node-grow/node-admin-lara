<?php

namespace NodeAdmin\Lib\NodeContent\Traits;

use Illuminate\Support\Collection;
use NodeAdmin\Exceptions\NodeException;
use NodeAdmin\Lib\NodeContent\Option;

trait HasOptions
{
    abstract protected function getOptionName():string;

    public function setOptions($options,$label_field='',$value_field=''){
        $option_name=$this->getOptionName();

        $this->render_data[$option_name]['options']=$this->transformOptions($options,$label_field,$value_field);

        return $this;
    }

    private function _isIndexArray(array $array){
        if (!$array){
            return false;
        }

        $keys=array_keys($array);
        $r=array_keys($keys) === $keys;
        if (!$r){
            return false;
        }
        if (is_array($array[0]) || is_object($array[0])){
            return true;
        }
        return false;
    }

    protected function transformOptions($options,$label_field,$value_field){
        if (!$options){
            return $options;
        }
        if ($options instanceof Collection){
            $options=array_map(function ($item)use ($label_field,$value_field){
                $item=(array)$item;
                return new Option($item[$value_field?:'value'],$item[$label_field?:'label']);
            },$options->toArray());
            return $options;
        }

        if (is_array($options)){
            if ($this->_isIndexArray($options)){
                return array_map(function ($item) use ($label_field,$value_field){
                    $item=(array)$item;
                    return new Option($item[$value_field ?: 'value'], $item[$label_field ?: 'label']);
                }, $options);
            }
            // 关联数组
            $res = [];
            foreach ($options as $value => $label) {
                $res[] = new Option($value, $label);
            }
            return $res;
        }

        if ($options instanceof \stdClass) {
            // 关联对象
            $res = [];
            foreach ($options as $value => $label) {
                $res[] = new Option($value, $label);
            }
            return $res;
        }

        throw new NodeException('无法处理该options的格式，请自行处理为数组或Collection');
    }
}

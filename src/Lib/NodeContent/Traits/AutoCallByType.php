<?php

namespace NodeAdmin\Lib\NodeContent\Traits;

use Illuminate\Support\Str;
use ReflectionClass;

trait AutoCallByType
{
    abstract protected function getAutoCallNamespace();
    abstract protected function getAutoCallMethod();

    public function __call(string $name, array $arguments)
    {
        $name=Str::ucfirst(Str::camel($name));

        $class_name=trim($this->getAutoCallNamespace(),'\\').'\\'.$name;
        $reflector = new ReflectionClass($class_name);
        $constructor = $reflector->getConstructor();
        $params=$constructor->getParameters();
        $args=[];
        foreach ($params as $param) {
            if (
                $param->getType()
                && $param->getType()->getName() !== \Closure::class
                && app($param->getType()->getName())
            ){
                continue;
            }
            isset($arguments[$param->getPosition()]) && $args[$param->getName()]=$arguments[$param->getPosition()];
        }

        $obj=app()->make($class_name,$args);

        $method = $this->getAutoCallMethod();
        $this->$method($obj);
        return $obj;
    }

}

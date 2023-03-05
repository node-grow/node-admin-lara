<?php
namespace NodeAdmin\Lib;


use Illuminate\Support\Str;
use NodeAdmin\Exceptions\NodeException;

trait CallConstantsStatic
{


    public static function __callStatic(string $name, array $arguments)
    {
        if (preg_match('/^get(\w+)List$/',$name,$m)){

            if ($res=cache()->get('constants_cache_'.$name)){
                return $res;
            }
            $class = new \ReflectionClass(get_called_class());
            $constants = $class->getConstants(\ReflectionClassConstant::IS_PUBLIC);
            $m=Str::snake($m[1]);
            $constants=array_filter(array_keys($constants),function ($name) use ($m){
                $m=Str::upper($m);
                return preg_match("/^${m}_[A-Z_]+$/", $name);
            });
            $res=[];
            foreach ($constants as $value=>$name) {
                $constant=$class->getReflectionConstant($name);
                $comment=$constant->getDocComment();
                $comment=trim($comment,"/ *\r\n");
                $res[$constant->getValue()]=$comment;
            }

            self::handleCache($name,$res);
            return $res;
        }elseif (preg_match('/^get(\w+)$/',$name,$m)){
            $method = $name . 'List';
            $res = call_user_func([get_called_class(), $method]);
            return $res[$arguments[0]];
        }
        throw new NodeException('没有找到或未实现"' . get_called_class() . '::' . $name . '"方法');
    }
}

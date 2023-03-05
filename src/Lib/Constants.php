<?php

namespace NodeAdmin\Lib;

/**
 * @method static getCommonStatus($status)
 * @method static getCommonStatusList()
 */
class Constants
{
    /** 正常 */
    const COMMON_STATUS_NORMAL=1;
    /** 禁用 */
    const COMMON_STATUS_FORBID=0;

    /** 测试 */
    const TEST=1111;
    use CallConstantsStatic;

    static protected function handleCache($name,$res){
        $cache_keys=cache()->get('constants_keys_cache')?:[];
        $cache_key='constants_cache_'.$name;
        $cache_keys[]=$cache_key;

        cache()->set($cache_key,$res,30);
        cache()->set('constants_keys_cache',$cache_keys);
    }

    static public function cacheUpdate(){
        $class = new \ReflectionClass(get_called_class());
        $md5 = md5_file($class->getFileName());
        cache()->set('constants_md5',$md5);
        $old_md5 = cache()->get('constants_md5') ?: '';
        if ($md5===$old_md5){
            return;
        }

        $cache_keys=cache()->get('constants_keys_cache')?:[];
        foreach ($cache_keys as $cache_key) {
            cache()->delete($cache_key);
        }
        cache()->delete('constants_keys_cache');
    }
}

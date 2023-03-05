<?php

namespace NodeAdmin\Lib\NodeContent;

use NodeAdmin\Exceptions\NodeException;

class Iconfont
{
    static public function getSymbols($symbol_url){
        $url=parse_url($symbol_url);
        if (!isset($url['scheme']) && isset($url['host'])){
            $symbol_url='http://'.ltrim($symbol_url,'/');
        }
        $content=file_get_contents(url($symbol_url));
        if (preg_match_all('/id="([\w-]+)"/',$content,$m)) {
            return $m[1];
        }else{
            throw new NodeException('该iconfont_url没有icon标识');
        }
    }
}

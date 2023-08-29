<?php

namespace NodeAdmin\Lib\Utils;


use Illuminate\Support\Facades\DB;
use NodeAdmin\Lib\Utils\MenuGenerator\MenuContainer;

class MenuGenerator
{
    static $pid = 0;

    public static function gen(\Closure $callback)
    {
        /** @var MenuContainer $container */
        $container = app()->make(MenuContainer::class);
        app()->call($callback, ['container' => $container]);

        DB::transaction(function () use ($container) {
            $container->run();
        });
    }
}

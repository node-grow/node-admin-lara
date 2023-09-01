<?php

namespace NodeAdmin\Lib\Utils;

use Illuminate\Support\Facades\DB;
use NodeAdmin\Lib\Utils\ConfigGenerator\ConfigContainer;

class ConfigGenerator
{
    public static function gen(\Closure $fn)
    {
        /** @var ConfigContainer $container */
        $container = app()->make(ConfigContainer::class);

        app()->call($fn, ['container' => $container]);

        DB::transaction(function () use ($container) {
            $container->run();
        });
    }
}

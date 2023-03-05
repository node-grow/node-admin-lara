<?php

namespace NodeAdmin\Lib\DiskHandlers;

abstract class BaseDiskHandler
{
    abstract public function getDiskName():string;

    abstract public function getFileUrl(string $path, $options=null):string;
}

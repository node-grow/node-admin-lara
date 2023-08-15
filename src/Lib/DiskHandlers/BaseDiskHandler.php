<?php

namespace NodeAdmin\Lib\DiskHandlers;

abstract class BaseDiskHandler
{
    protected array $default_options = [];

    abstract public function getDiskName(): string;

    abstract public function getFileUrl(string $path, $options = null): string;

    /**
     * @param array $default_options
     */
    public function setDefaultOptions(array $default_options): void
    {
        $this->default_options = $default_options;
    }

    protected function transformOptions($options)
    {
        return array_merge($this->default_options, $options ?? []);
    }
}

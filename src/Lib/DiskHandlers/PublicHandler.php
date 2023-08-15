<?php

namespace NodeAdmin\Lib\DiskHandlers;

use Illuminate\Support\Facades\Storage;

class PublicHandler extends BaseDiskHandler
{

    public function getDiskName(): string
    {
        return 'public';
    }

    public function getFileUrl(string $path, $options = null): string
    {
        $options = $this->transformOptions($options);

        return Storage::disk('public')->url($path);
    }
}

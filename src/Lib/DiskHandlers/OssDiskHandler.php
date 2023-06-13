<?php

namespace NodeAdmin\Lib\DiskHandlers;

use Iidestiny\Flysystem\Oss\OssAdapter;
use Illuminate\Support\Facades\Storage;
use OSS\OssClient;

class OssDiskHandler extends BaseDiskHandler
{

    public function getDiskName(): string
    {
        return 'oss';
    }

    public function getFileUrl(string $path, $options = null): string
    {
        $default_options = [
            'timeout' => 86400,
        ];
        $options = array_merge($default_options, $options ?? []);

        $timeout = $options['timeout'];
        unset($options['timeout']);
        if (!$timeout) {
            return $this->getFileUrlForever($path, $options);
        }
        $cache_key = md5($this->getDiskName() . $path . implode(',', $options));
        if ($url = cache()->get($cache_key)) {
            return $url;
        }

        /** @var OssAdapter $adapter */
        $adapter = Storage::disk($this->getDiskName())->getAdapter();
        $url = $adapter->getTemporaryUrl($path, $timeout, $options);
        cache()->put($cache_key, $url, max($timeout - 200, 1));
        return $url;
    }

    public function getFileUrlForever(string $path, $options = []): string
    {
        /** @var OssAdapter $adapter */
        $adapter = Storage::disk($this->getDiskName())->getAdapter();
        $url = $adapter->getUrl($path);
        if (isset($options[OssClient::OSS_PROCESS])) {
            $url .= '?' . OssClient::OSS_PROCESS . '=' . $options[OssClient::OSS_PROCESS];
        }
        return $url;
    }
}

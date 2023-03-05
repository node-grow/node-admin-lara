<?php

namespace NodeAdmin\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use NodeAdmin\Lib\Upload\BaseUploadController;
use NodeAdmin\Lib\Upload\UploadConfigResponse;
use NodeAdmin\Lib\Upload\UploadResponse;
use NodeAdmin\Models\Files;

class UploadController extends BaseUploadController
{
    protected $disk='oss';

    protected function getAdapter(){
        return Storage::disk($this->disk)->getAdapter();
    }

    public function getUploadConfig($options = []): UploadConfigResponse
    {
        $dir = $options['dir'] ?? 'file/';
        $callbackUrl = $options['callback'] ?? action([get_class($this), 'callback']);
        $customData = [
            'filename' => \request()->input('filename'),
            'size' => \request()->input('size'),
            'type' => \request()->input('type'),
            'key' => $dir . Str::random() . time() . $this->getExt(\request()->input('filename')),
        ];
        $config = $this->getAdapter()->signatureConfig($dir, $callbackUrl, $customData);
        $body = $this->buildBody($config, $customData['key']);
        return new UploadConfigResponse($body['host'], $body);
    }

    public function callback(): UploadResponse
    {
        $bucket = config('filesystems.disks.' . $this->disk . '.bucket');
        $acl = $this->getAdapter()->getClient()->getBucketAcl($bucket);
        $url = null;
        if (in_array($acl, ['public-read', 'public-read-write'])) {
            $url = $this->getAdapter()->getUrl(\request()->input('key'));
        }

        $id = Files::query()->create([
            'disk' => $this->disk,
            'filename' => \request()->input('filename', ''),
            'url' => $url ?: '',
            'size' => \request()->input('size', 0),
            'type' => \request()->input('type', ''),
            'ext' => $this->getExt(\request()->input('filename')),
            'path' => request()->input('key'),
        ])->id;
        $url = $url ?: getFileUrl($id);

        return new UploadResponse($url, $id);
    }

    protected function buildBody($config, $key)
    {
        $config = json_decode($config, true);
        $body = [
            'policy' => $config['policy'],
            'OSSAccessKeyId' => $config['accessid'],
            'signature' => $config['signature'],
            'host' => $config['host'],
            'callback' => $config['callback'],
            'key' => $key,
        ];
        foreach ($config['callback-var'] as $key => $value) {
            $body[$key] = $value;
        }
        return $body;
    }

    /**
     * @param string $disk
     * @return $this
     */
    public function setDisk(string $disk): self
    {
        $this->disk = $disk;
        return $this;
    }
}

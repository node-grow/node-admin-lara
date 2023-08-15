<?php

namespace NodeAdmin\Http\Controllers\Upload;

use Illuminate\Filesystem\Filesystem;
use NodeAdmin\Exceptions\NodeException;
use NodeAdmin\Lib\Upload\BaseUploadController;
use NodeAdmin\Lib\Upload\UploadConfigResponse;
use NodeAdmin\Lib\Upload\UploadResponse;
use NodeAdmin\Models\Files;

class PublicController extends BaseUploadController
{
    protected $disk = 'public';

    public function getUploadConfig($options = []): UploadConfigResponse
    {
        $fs = new Filesystem();
        if (!$fs->exists(public_path('storage'))) {
            throw new NodeException('please run storage:link first');
        }

        $customData = [
            'filename' => \request()->input('filename'),
            'size' => \request()->input('size'),
            'type' => \request()->input('type'),
        ];
        return new UploadConfigResponse(action([get_class($this), 'callback']), $customData);
    }

    public function callback(): UploadResponse
    {
        if (!request()->hasFile('file')) {
            throw new NodeException('找不到文件file');
        }

        if (!request()->file('file')->isValid()) {
            throw new NodeException('非法文件');
        }

        $path = request()->file('file')->store('file', $this->disk);

        $id = Files::query()->create([
            'disk' => $this->disk,
            'filename' => \request()->input('filename', ''),
            'url' => '',
            'size' => \request()->input('size', 0),
            'type' => \request()->input('type', ''),
            'ext' => $this->getExt(\request()->input('filename')),
            'path' => $path,
        ])->id;
        $url = getFileUrl($id);

        return new UploadResponse($url, $id);
    }
}

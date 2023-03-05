<?php

namespace NodeAdmin\Lib\Upload;

use NodeAdmin\Lib\NodeContent\NodeResponse;

class UploadResponse extends NodeResponse
{
    public function __construct($url,$id)
    {
        parent::__construct([
            'id'=>$id,
            'url'=>$url,
        ]);
    }
}

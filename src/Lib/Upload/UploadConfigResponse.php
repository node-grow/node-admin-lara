<?php

namespace NodeAdmin\Lib\Upload;

use NodeAdmin\Lib\NodeContent\NodeResponse;

class UploadConfigResponse extends NodeResponse
{
    public function __construct($url,$body,$headers=[],$method='post')
    {
        $data=[
            'url' => $url,
            'body' => $body,
            'headers' => $headers,
            'method'=>$method,
        ];
        parent::__construct($data);
    }
}

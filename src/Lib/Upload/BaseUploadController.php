<?php

namespace NodeAdmin\Lib\Upload;

abstract class BaseUploadController
{
    /**
     * 获取上传配置接口，返回前端真实上传url、body和headers
     * @return UploadConfigResponse
     */
    abstract public function getUploadConfig():UploadConfigResponse;

    protected function getExt($filename){
        if (strpos($filename,'.')===false){
            return '';
        }
        return '.'.last(explode('.',$filename));
    }

    public function action():UploadResponse{
        return new UploadResponse('','');
    }

    public function callback():UploadResponse{
        return new UploadResponse('','');
    }
}

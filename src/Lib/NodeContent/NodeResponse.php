<?php

namespace NodeAdmin\Lib\NodeContent;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\JsonResponse;

class NodeResponse extends JsonResponse
{

    public function __construct($data,$message='',$errors=[],$code=200,$statusCode=200)
    {
        parent::__construct();
        $res=[
            'code'=>$code,
            'message'=>$message,
            'data'=>$this->transformData($data),
        ];
        $errors && $res['errors']=$errors;
        $this->setStatusCode($statusCode);
        parent::setData($res);
    }

    protected function transformData($data){
        if ($data instanceof Arrayable) {
            return $data->toArray();
        } elseif ($data instanceof Jsonable) {
            return json_decode($data->toJson(),true);
        }
        return $data;
    }

}

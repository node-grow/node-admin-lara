<?php

namespace NodeAdmin\Exceptions;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use NodeAdmin\Lib\NodeContent\NodeResponse;
use Throwable;

class NodeException extends Exception implements Renderable
{
    public $http_code = 400;

    public $errors;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, intval($code), $previous);
    }

    //
    public function render()
    {
        $trans=new NodeResponse(null,$this->getMessage(),$this->errors ?? [], $this->getCode() ?? 0);
        $trans->setStatusCode($this->http_code);
        return $trans->withException($this);
    }

    public function setMessage($message){
        $this->message=$message;
    }

}

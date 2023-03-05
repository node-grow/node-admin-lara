<?php

namespace NodeAdmin\Lib\NodeContent\Operation;

class Request extends BaseOperation
{
    public function __construct($url,$method,$body=null)
    {
        $this->render_data['type']='request';
        $this->render_data['operation_option']['url']=$url;
        $this->render_data['operation_option']['method']=$method;
        $this->render_data['operation_option']['body']=$body;
        $this->render_data['operation_option']['confirm']='';
    }

    /**
     * @param $confirm
     * @return $this
     */
    public function setConfirm($confirm){
        $this->render_data['operation_option']['confirm']=$confirm;
        return $this;
    }

    /**
     * @param array $body
     * @return $this
     */
    public function setBody(array $body){
        $this->render_data['operation_option']['body']=(object)$body;
        return $this;
    }

    /**
     * @param string $method
     * @return $this
     */
    public function setMethod(string $method){
        $this->render_data['operation_option']['method']=$method;
        return $this;
    }
}

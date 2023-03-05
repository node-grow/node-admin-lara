<?php

namespace NodeAdmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUser extends FormRequest
{
    use RequestTrait;

    public function rules()
    {
        return [
            'username' => 'required',
            'password' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'username' => '用户名',
            'password' => '密码'
        ];
    }


}

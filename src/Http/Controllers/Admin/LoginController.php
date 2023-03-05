<?php

namespace NodeAdmin\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use NodeAdmin\Exceptions\NodeException;
use NodeAdmin\Http\Requests\LoginUser;
use NodeAdmin\Services\AdminUserService;

class LoginController extends Controller
{
    public function loginIn(LoginUser $request, AdminUserService $adminUserService)
    {
        $admin_user = $adminUserService->login(
            $request->input('username'),
            $request->input('password')
        );

        //调用captcha_api_check方法。
        $captcha = $request->input('captcha'); //验证码
        $key = $request->input('captcha_key'); //key

        if (!captcha_api_check($captcha, $key,'admin')) {
            throw new NodeException('验证码不正确');
        }

        $token = $admin_user->createToken('admin_api')->accessToken;
        return [
            'need_validate' => true,
            'token' => 'Bearer '.$token
        ];
    }


    public function loginOut(Request $request,AdminUserService $service)
    {
        $service->logout($request);
    }

    public function getUser(Request $request){
        return $request->user()->toArray();
    }

    public function validateCode()
    {
        return app('captcha')->create('admin', true); //create是生成验证码的方法;
    }

}

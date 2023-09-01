<?php

namespace NodeAdmin\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use NodeAdmin\Exceptions\NodeException;
use NodeAdmin\Models\AdminUser;

class AdminUserService
{
    public function login($username,$password)
    {
        $admin_user = AdminUser::query()->where('username', $username)->first();
        if (!$admin_user) {
            throw new NodeException('用户不存在');
        }

        if (!Hash::check($password, $admin_user->password)) {
            throw new NodeException('密码不正确');
        }

        return $admin_user;
    }

    public function logout(Request $request){
        $request->user()->token()->delete();
        $token=$request->bearerToken();
        cache()->forget($token.'.permission_paths');
        return true;
    }

    public function saveVidation($check_password = true)
    {
        Validator::make(\request()->input(),[
            'username'=>['required'],
            'password' => $check_password ? ['required', Password::min(6)] : [Password::min(6)],
            'role_id' => ['required'],
        ], [], ['username' => '用户名', 'password' => '密码', 'role_id' => '角色'])->validate();

        $username = request()->input('username');
        $password = request()->input('password');
        $role_id = request()->input('role_id');
        $password = \Illuminate\Support\Facades\Hash::make($password);
        return [$username, $password, $role_id];
    }
}

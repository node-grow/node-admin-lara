<?php

namespace NodeAdmin\Services;

use Illuminate\Support\Facades\DB;
use NodeAdmin\Models\AdminRole;
use NodeAdmin\Models\AdminRolePermission;

class AdminRoleService
{
    public function update(AdminRole $role,array $permissions){
        DB::transaction(function () use ($permissions, $role){
            $role->save();
            AdminRolePermission::query()->where('role_id',$role->id)->delete();
            collect($permissions)->map(function ($permission) use ($role) {
                $rp=new AdminRolePermission();
                $rp->role_id=$role->id;
                $rp->permission_id=$permission['id'];
                $rp->save();
            });
        });
    }

    public function store($inputs){
        DB::transaction(function () use ($inputs) {
            $role=AdminRole::query()->forceCreate([
                'name'=>$inputs['name'],
                'description'=>isset($inputs['description'])?$inputs['description']:'',
            ]);
            collect($inputs['permissions']??[])->map(function ($permission) use ($role) {
                $rp=new AdminRolePermission();
                $rp->role_id=$role->id;
                $rp->permission_id=$permission['id'];
                $rp->save();
            });
        });
    }
}

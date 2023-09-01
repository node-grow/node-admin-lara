<?php

namespace NodeAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use NodeAdmin\Exceptions\NodeException;

class AdminRole extends Model
{

    protected static function boot()
    {
        parent::boot();
        self::deleting(function (self $role) {
            if ($role->id == config('admin.super_admin_role_id')) {
                throw new NodeException('超管角色必须存在');
            }
        });
    }

    public function permissions(){
        return $this->hasManyThrough(
            AdminPermission::class,
            AdminRolePermission::class,
            'role_id',
            'id',
            'id',
            'permission_id',
        );
    }
}

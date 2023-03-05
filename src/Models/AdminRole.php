<?php

namespace NodeAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{

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

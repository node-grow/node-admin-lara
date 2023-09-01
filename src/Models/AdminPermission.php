<?php

namespace NodeAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use NodeAdmin\Exceptions\NodeException;

class AdminPermission extends Model
{
    protected static function boot()
    {
        parent::boot();
        self::deleting(function (self $permission) {
            if (self::query()->where('pid', $permission->id)->exists()) {
                throw new NodeException('该权限点有下级，不能删除');
            }
        });
    }
}

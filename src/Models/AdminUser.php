<?php

namespace NodeAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use NodeAdmin\Exceptions\NodeException;

class AdminUser extends User
{

    use HasApiTokens, HasFactory, Notifiable;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $fillable = [
        'username',
        'password'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::deleting(function (self $user) {
            if (static::query()->count() <= 1) {
                throw new NodeException('至少有一个管理员');
            }
        });
    }

    public function role()
    {
        return $this->belongsTo(AdminRole::class, 'role_id', 'id');
    }

    public function getPermissionRoutesAttribute()
    {
        $permissions = $this->role->permissions;
        $routes = [];

        foreach ($permissions as $permission) {
            $routes = array_merge_recursive($routes, explode("\n", $permission->routes));
        }

        return $routes;
    }

}

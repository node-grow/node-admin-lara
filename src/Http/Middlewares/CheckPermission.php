<?php

namespace NodeAdmin\Http\Middlewares;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use NodeAdmin\Models\AdminUser;
use NodeAdmin\Services\AdminPermissionService;

class CheckPermission
{
    protected $cached = false;
    protected $service;

    public function __construct(AdminPermissionService $service)
    {
        $this->service = $service;
    }

    protected function getCachedRoutes()
    {
        $token = \request()->bearerToken();
        return cache()->get($token . '.permission_routes') ?? [];
    }

    protected function cachedPermission()
    {
        $token = \request()->bearerToken();
        $current_name = Route::currentRouteName();
        cache()->set($token . '.permission_routes', [...$this->getCachedRoutes(), $current_name], 600);
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, \Closure $next)
    {
        if ($this->cached && $this->checkCache()) {
            return $next($request);
        }
        if (!$this->check($request)) {
            abort(403, '无此操作权限');
        }

        $this->cachedPermission();
        return $next($request);
    }

    protected function checkCache()
    {
        $current_name = Route::currentRouteName();
        return in_array($current_name, $this->getCachedRoutes());
    }

    protected function check(Request $request)
    {
        /** @var AdminUser $user */
        $user = $request->user();
        if ($user->role->id == config('admin.super_admin_role_id')) {
            return true;
        }
        return $this->service->check(\request()->route(), $user);
    }
}

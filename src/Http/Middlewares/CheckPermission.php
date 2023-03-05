<?php

namespace NodeAdmin\Http\Middlewares;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use NodeAdmin\Models\AdminUser;

class CheckPermission
{
    protected $cached=true;

    protected function getCachedPaths(){
        $token=\request()->bearerToken();
        return cache()->get($token.'.permission_paths') ?? [];
    }

    protected function cachedPermission(){
        $token=\request()->bearerToken();
        $path=\request()->getPathInfo();
        cache()->set($token.'.permission_paths',[...$this->getCachedPaths(),$path],600);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, \Closure $next)
    {
        if ($this->cached && $this->checkCache()){
            return $next($request);
        }
        if (!$this->check($request)){
            abort(403,'无此操作权限');
        }

        $this->cachedPermission();
        return $next($request);
    }

    protected function checkCache(){
        $path=\request()->getPathInfo();
        return in_array($path,$this->getCachedPaths());
    }

    protected function check(Request $request){
        /** @var AdminUser $user */
        $user=$request->user();
        $permissions=$user->append('permissions')->permissions;
        foreach ($permissions as $permission) {
            if ($request->is(Str::replace('.','/',$permission->path))){
                return true;
            }
        }
        return false;
    }
}

<?php

namespace NodeAdmin;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\ResourceRegistrar;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use NodeAdmin\Console\Commands\DistinctByDB;
use NodeAdmin\Console\Commands\DownloadAssets;
use NodeAdmin\Console\Commands\Install;
use NodeAdmin\Http\Middlewares\CheckPermission;
use NodeAdmin\Http\Middlewares\TransformException;
use NodeAdmin\Http\Middlewares\TransformReturn;
use NodeAdmin\Lib\Constants;
use NodeAdmin\Lib\DiskHandlers\OssDiskHandler;
use NodeAdmin\Lib\NodeResourceRegistrar;
use NodeAdmin\Models\AdminUser;
use NodeAdmin\Models\Files;

class NodeAdminProvider extends ServiceProvider
{
    protected $commands= [
        Install::class,
        DownloadAssets::class,
        DistinctByDB::class,
    ];

    protected $middlewareGroups=[
        'node-admin'=>[
            SubstituteBindings::class,
            TransformException::class,
            TransformReturn::class,
        ],
        'admin:auth'=>[
            'auth:admin',
            CheckPermission::class,
        ]
    ];

    public function register()
    {
        !defined('NODE_ADMIN_PATH') && define('NODE_ADMIN_PATH',realpath(__DIR__.'/..'));

        //配置
        $this->registerConfig();

        //注册中间件
        $this->registerRouteMiddleware();

        //命令
        $this->commands($this->commands);

        //混入方法
        $this->macroMethods();

        //注册FileHandler
        Files::addDiskHandler(new OssDiskHandler());
    }

    protected function registerConfig(){

        $this->mergeConfigFrom(NODE_ADMIN_PATH.'/config/admin.php','admin');

        config()->set('auth.guards.admin',config('admin.auth'));

        $provider=config('admin.auth.provider');
        config()->set('auth.providers.'.$provider, [
            'driver' => 'eloquent',
            'model' => AdminUser::class
        ]);

        config()->set('captcha.admin', config('admin.captcha'));
    }

    protected function registerRouteMiddleware(){
        // 注册中间件分组
        foreach ($this->middlewareGroups as $key => $middleware) {
            app('router')->middlewareGroup($key, $middleware);
        }
    }

    public function boot(){
        //检查常量文件是否需要更新
        Constants::cacheUpdate();

        //迁移
        $this->loadMigrationsFrom(NODE_ADMIN_PATH.'/database/migrations');

        //passport token有效期
        $this->passportTokenSetting();

        //路由
        $this->loadAdminRoutes();

        //视图
        $this->loadViewsFrom(NODE_ADMIN_PATH . '/resources/views', 'admin');

        //发布
        $this->publishes([
            NODE_ADMIN_PATH . '/config/admin.php' => config_path('admin.php'),
        ], 'admin-config');

        $this->publishes([
            NODE_ADMIN_PATH . '/publish/distinct-by-db/migrations' => database_path('migrations'),
        ], 'distinct-by-db');
    }

    protected function loadAdminRoutes(){
        $fs=$this->app->make(Filesystem::class);
        if (!$fs->exists(base_path('routes/admin.php'))){
            return;
        }
        Route::middleware(['node-admin'])
            ->prefix('/admin')
            ->name('admin.')
//            ->group(NODE_ADMIN_PATH.'/route/admin.php');
            ->group(base_path('routes/admin.php'));
    }

    protected function passportTokenSetting(){
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
    }

    protected function macroMethods()
    {
        $this->app->bind(ResourceRegistrar::class,NodeResourceRegistrar::class);
    }

}

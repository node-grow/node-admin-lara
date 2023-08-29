<?php
// auto add admin routes
use Illuminate\Support\Facades\Route;
use NodeAdmin\Http\Controllers as Controllers;

Route::prefix('login')->name('login.')->group(function () {
    Route::post('user', [Controllers\Admin\LoginController::class, 'loginIn'])->name('user');
    Route::get('validateCode', [Controllers\Admin\LoginController::class, 'validateCode'])->name('validateCode');
});

Route::get('/common/config/backend', [Controllers\Admin\ConfigController::class, 'getOneConfig'])->name('common.config.backend');

Route::middleware('admin:auth')->group(function () {
    Route::delete('/login/user', [Controllers\Admin\LoginController::class, 'loginOut'])->name('login.user.logout');
    Route::get('/user/current/module', [Controllers\Admin\MenuController::class, 'getModule'])->name('user.current.module');
    Route::get('/user/current/menu/{module?}', [Controllers\Admin\MenuController::class, 'getMenu'])->name('user.current.menu');
    Route::get('/user/current/info', [Controllers\Admin\LoginController::class, 'getUser'])->name('user.current.info');

    Route::get('/upload/getUploadConfig', [Controllers\Admin\UploadController::class, 'getUploadConfig'])->name('upload');

    Route::get('/common/system/info', [Controllers\Admin\SystemInfoController::class, 'index'])->name('common.system.info');

    Route::resource('users', Controllers\Admin\AdminUserController::class);

    Route::resource('menu', Controllers\Admin\AdminMenuController::class);
    Route::put('menu/{menu}/sort', [Controllers\Admin\AdminMenuController::class, 'sort'])->name('menu.sort');

    Route::get('sysSetting', [Controllers\Admin\ConfigController::class, 'getConfig'])->name('sysSetting.index');
    Route::post('update', [Controllers\Admin\ConfigController::class, 'update'])->name('config.update');

    Route::resource('permission', Controllers\Admin\PermissionController::class);
    Route::resource('role', Controllers\Admin\RoleController::class);
    Route::resource('log', Controllers\Admin\LogController::class)->only([
        'index', 'store'
    ]);

});

Route::resource('divisions',Controllers\Admin\DivisionsController::class,[
    'only'=>['index','show']
]);

Route::post('/upload/callback', [Controllers\Admin\UploadController::class, 'callback'])->name('upload.callback');
// auto add admin routes end

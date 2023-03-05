<?php
// auto add admin routes
use Illuminate\Support\Facades\Route;
use NodeAdmin\Http\Controllers as Controllers;

Route::prefix('login')->group(function (){
    Route::post('user', [Controllers\Admin\LoginController::class, 'loginIn']);
    Route::get('validateCode', [Controllers\Admin\LoginController::class, 'validateCode']);
});

Route::get('/common/config/backend', [Controllers\Admin\ConfigController::class, 'getOneConfig']);

Route::middleware('admin:auth')->group(function () {
    Route::delete('/login/user', [Controllers\Admin\LoginController::class, 'loginOut']);
    Route::get('/user/current/menu', [Controllers\Admin\MenuController::class, 'getMenu']);
    Route::get('/user/current/info', [Controllers\Admin\LoginController::class, 'getUser']);

    Route::get('/upload/getUploadConfig', [Controllers\Admin\UploadController::class, 'getUploadConfig'])->name('upload');

    Route::get('/common/system/info', [Controllers\Admin\SystemInfoController::class, 'index']);
//    Route::get('dashboard',[Controllers\Admin\SystemInfoController::class,'index']);

    Route::resource('users', Controllers\Admin\AdminUserController::class);

    Route::resource('menu', Controllers\Admin\AdminMenuController::class);
    Route::put('menu/{menu}/sort', [Controllers\Admin\AdminMenuController::class, 'sort']);

    Route::get('sysSetting', [Controllers\Admin\ConfigController::class, 'getConfig']);
    Route::post('update', [Controllers\Admin\ConfigController::class, 'update']);

    Route::resource('permission', Controllers\Admin\PermissionController::class);
    Route::resource('role', Controllers\Admin\RoleController::class);
    Route::resource('log', Controllers\Admin\LogController::class)->only([
        'index', 'store'
    ]);

});

Route::resource('divisions',Controllers\Admin\DivisionsController::class,[
    'only'=>['index','show']
]);

Route::post('/upload/ossCallback',[Controllers\Admin\UploadController::class,'callback']);
// auto add admin routes end

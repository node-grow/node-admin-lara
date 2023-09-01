<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use NodeAdminDatabase\Seeders;


return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \NodeAdmin\Models\AdminRolePermission::query()->delete();
        Schema::dropIfExists('admin_permissions');
        //
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->text('routes')->comment('路由名列表，可用*');
            $table->bigInteger('pid')->default(0);
            $table->timestamps();
        });

        $parent = \NodeAdmin\Models\AdminPermission::query()->forceCreate([
            'name' => '平台管理',
            'routes' => 'admin.*',
        ]);

        \NodeAdmin\Models\AdminPermission::query()->forceCreate([
            'name' => '后台必要权限',
            'routes' => <<<TXT
admin.login.user.logout
admin.user.*
admin.upload
admin.common.system.info
TXT,
            'description' => '新增角色时此权限点必选',
            'pid' => $parent->id,
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('admin_permissions');
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->comment('权限名');
            $table->string('path', 255)->comment('权限点路径，可将请求路径的/替换为.的字符串，可带*');
            $table->string('description', 255)->nullable()->comment('描述');
            $table->bigInteger('pid')->default(0)->comment('上级id');

            $table->timestamps();
        });

        Artisan::call('db:seed', ['--class' => Seeders\AdminRoleSeeder::class]);
        Artisan::call('db:seed', ['--class' => Seeders\AdminPermissionSeeder::class]);
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use NodeAdminDatabase\Seeders;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //角色表
        Schema::create('admin_roles',function (Blueprint $table){
            $table->id();
            $table->string('name',50)->comment('角色名');
            $table->string('description',255)->nullable()->comment('描述');
            $table->timestamps();
        });

        Schema::table('admin_users',function (Blueprint $table){
            $table->bigInteger('role_id')->nullable()->comment('角色id');
        });

        //权限表
        Schema::create('admin_permissions',function (Blueprint $table){
            $table->id();
            $table->string('name',50)->comment('权限名');
            $table->string('path',255)->comment('权限点路径，可将请求路径的/替换为.的字符串，可带*');
            $table->string('description',255)->nullable()->comment('描述');
            $table->bigInteger('pid')->default(0)->comment('上级id');

            $table->timestamps();
        });

        //角色权限关联表
        Schema::create('admin_role_permissions',function (Blueprint $table){
            $table->bigInteger('role_id')->comment('角色id');
            $table->bigInteger('permission_id')->comment('权限id');

            $table->index(['role_id','permission_id']);
        });

        Artisan::call('db:seed', ['--class' =>Seeders\AdminRoleSeeder::class]);
        Artisan::call('db:seed', ['--class' =>Seeders\AdminPermissionSeeder::class]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('admin_roles');
        Schema::table('admin_users',function (Blueprint $table){
            $table->dropColumn('role_id');
        });
        Schema::dropIfExists('admin_permissions');
        Schema::dropIfExists('admin_role_permissions');
    }
};

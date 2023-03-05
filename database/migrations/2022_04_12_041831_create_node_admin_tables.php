<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->id();
            $table->string('username',50);
            $table->string('password',100);
            $table->tinyInteger('status')->default(1)->comment('状态 0禁用1启用');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('admin_menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',50)->nullable()->comment('控制器名');
            $table->string('title',50)->nullable()->comment('菜单名');
            $table->tinyInteger('level')->default(1)->comment('菜单等级,默认第一级');
            $table->integer('pid')->default(0)->comment('父级菜单id,默认第一级');
            $table->string('icon',200)->nullable()->comment('图标类名');
            $table->integer('sort')->default(0)->comment('排序');
            $table->tinyInteger('status')->default(1)->comment('状态 0为禁用 1为正常');
            $table->string('url')->nullable()->comment('其他访问地址');
            $table->timestamps();
        });

        Schema::create('config', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable()->comment('配置名');
            $table->string('title',100)->nullable()->comment('字段名');
            $table->string('type',50)->nullable()->comment('类型');
            $table->text('value')->nullable()->comment('内容/值');
            $table->string('tips')->nullable()->comment('提示');
            $table->string('option')->nullable()->comment('配置项');
            $table->tinyInteger('status')->default(1)->comment('状态,1正常 0禁用,默认1');
            $table->integer('sort')->default(0)->comment('排序');
            $table->timestamps();
        });

        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename',150)->comment('文件名');
            $table->string('disk',200)->default('local')->comment('配置的disk');
            $table->string('path',200)->nullable()->comment('路径');
            $table->string('url',500)->comment('远程url');
            $table->string('size')->comment('文件大小/kb');
            $table->string('type')->comment('文件类型');
            $table->string('ext')->comment('文件拓展名');
            $table->tinyInteger('status')->default(1)->comment('文件状态,0禁用1正常-1删除');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' =>\NodeAdminDatabase\Seeders\AdminMenuSeeder::class]);
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' =>\NodeAdminDatabase\Seeders\AdminUserSeeder::class]);
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' =>\NodeAdminDatabase\Seeders\ConfigSeeder::class]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
        Schema::dropIfExists('admin_menu');
        Schema::dropIfExists('config');
        Schema::dropIfExists('files');

    }
};

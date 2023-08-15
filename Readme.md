# Node-Admin package

## 说明

该项目用于适配 [node-admin](https://github.com/node-grow/node-admin-front) 的接口

## 用法

1. 创建laravel项目
    ```shell
    composer create-project laravel/laravel [项目目录名称]
    ```

2. 引入node-admin

    ```shell
    cd [项目目录]
    composer require node-admin/node-admin
    ```

3. 更改.env文件信息后执行初始化
    ```shell
    php artisan node-admin:install
    ``` 

4. [可选] 执行命令下载后台前端资源

    ```shell
    php artisan node-admin:download-assets
    
    # 若不能下载可使用代理
    php artisan node-admin:download-assets --proxy=[代理url] 
    ```

### 上传文件说明

前提：执行完上述命令

1. 把 App\Http\Controllers\Admin\UploadController 修改继承NodeAdmin\Http\Controllers\Upload\下的基类
    ```php 
   //例：
    <?php
   
    namespace App\Http\Controllers\Admin;
    
    use NodeAdmin\Http\Controllers\Upload\PublicController;
    
    class UploadController extends PublicController
    {
    }

   ```

2. 在App\Providers\AppServiceProvider 注册 文件处理类
   ```php
    use Illuminate\Support\ServiceProvider;
    use NodeAdmin\Lib\DiskHandlers\PublicHandler;
    use NodeAdmin\Models\Files;
    
    class AppServiceProvider extends ServiceProvider
    {
        // ...
        public   function boot()
        {
            // ...
            Files::addDiskHandler(new PublicHandler());
        }
    }
   ```

## 更新日志

### 1.2.0

1. 添加node-admin:distinct-by-db命令，可将地区爬取到数据库中

```shell
php artisan node-admin:distinct-by-db
# 或发布迁移文件
php artisan vendor:publish --tag=distinct-by-db
```

### 1.1.0

1. 添加node-admin:download-assets命令，将前端资源下载到/public/admin目录

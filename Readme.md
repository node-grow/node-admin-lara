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

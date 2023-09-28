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

### 1.4.0

1. 渲染类型tabPanel及操作modal、addTab增加前置渲染数据功能

```php
/** @var Form $form */
$form = app()->make(Form::class);
$form->items(function (Form\ItemsContainer $container) {
    $container->text('name', 'name')->setText('name');
});
$form->actions(function (Form\ActionsContainer $container) {
    /** @var Table $table */
    $table = app()->make(Table::class);
    $table->columns(function (Table\ColumnsContainer $container) {
        $container->text('id', 'ID');
    });
    $container->button('小样tab')->addTab('', '小样tab')->setNodeData($table);
    $container->button('小样modal')->modal('', '小样modal')->setNodeData($table);
});
$container->tab_pane('list', '列表', '')->setNodeData($form);
```

2. 改用opcodesio/log-viewer包读取日志文件，提升日志读取速度

### 1.3.0

1. 增加菜单生成工具类

```php
use NodeAdmin\Lib\Utils\MenuGenerator;

MenuGenerator::gen(function (MenuGenerator\MenuContainer $container) {
    // 父菜单
    $container->collapse('测试1111')->children(function (MenuGenerator\MenuContainer $container) {
        // 子菜单
        $container->link('哈哈', 'menu');
    });
});
```

2. 增加多管理模块配置

```php
// 将下列代码放入 config/admin.php
    'modules' => [
        'admin' => [ // 默认模块，请勿删除
            'nav' => '平台',
            'route' => [
                'name' => 'admin.',
                'file' => base_path('routes/admin.php'),
                'prefix' => '/admin',
            ]
        ],
        
        'admin2' => [//增加的模块标识
            'nav' => '平台2', //后台顶部菜单名
            'route' => [ //路由组配置
                'name' => 'admin2.', //路由组名
                'file' => base_path('routes/admin2.php'), //路由组文件
                'prefix' => '/admin2', //路由组前缀
            ]
        ]
    ],
```

3. 增加菜单badge配置

```php
//app/Http/Controllers/Admin/MenuController.php

public function getMenu($module = 'admin')
{
    $this->route_badge = [
        //菜单路由名 => 徽标数
        'admin.menu.index' => 10,
    ];

    return parent::getMenu($module);
}
```

4. 增加模块badge配置

```php
//app/Http/Controllers/Admin/MenuController.php

public function getModule()
{
    $this->module_badge = [
        //模块标识 => 徽标数
        'admin' => 10
    ];
    return parent::getModule();
}
```

### 1.2.0

1. 添加node-admin:distinct-by-db命令，可将地区爬取到数据库中

```shell
php artisan node-admin:distinct-by-db
# 或发布迁移文件
php artisan vendor:publish --tag=distinct-by-db
```

### 1.1.0

1. 添加node-admin:download-assets命令，将前端资源下载到/public/admin目录

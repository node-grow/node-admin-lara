# Node-Admin package

## 说明

## 用法

1. 创建laravel项目
```shell
composer create-project laravel/laravel [项目目录名称]
```

2. 初始化git
```shell
cd [项目目录]
git init
mkdir -p packages/node
cd packages/node
git submodule add git@codeup.aliyun.com:6254df80a923b68581caaf62/node/node-admin.git
```

3. 更改composer.json配置
```json5
{
    //...,
    "repositories": [
        {
            "type": "path",
            "url": "packages/node/node-admin"
        }
    ],
    "require": {
        // ...,
        "node/node-admin": "dev-master"
    },
    //...
}
```

4. 返回项目目录执行安装依赖包
```shell
cd [项目目录]
composer update
```

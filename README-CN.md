# Nice Opening SDK for Laravel

## [README of Chinese](https://github.com/aliyun/aliyun-oss-php-sdk/blob/master/README-CN.md)

## 概述

Nice是一个面向外部的集成管理平台。

## 运行环境
- PHP 7.2+.
- Firebase/php-jwt  5.4
- Guzzlehttp/guzzle  6.5

## 安装方法

- 如果您通过composer管理您的项目依赖，可以在你的项目根目录运行：
-
      composer require niceopening/nice-laravel

或者在你的`composer.json`中声明对Nice for Laravel的依赖：

      "require": {
          "niceopening/nice-laravel": "dev-master"
      }

然后通过`composer install`安装依赖。composer安装完成后，在您的PHP代码中引入依赖即可：

      require_once __DIR__ . '/vendor/autoload.php';

- 您也可以直接下载已经打包好的[phar文件][releases-page]，然后在你的代码中引入这个文件即可：

        require_once '/path/to/nice-opening.phar';

- 下载SDK源码，在您的代码中引入SDK目录下的`autoload.php`文件：

        require_once '/path/to/nice-opening/autoload.php';

## 快速使用

### 常用类

| 类名 | 解释 |
|:------------------|:------------------------------------|
|laravel\NiceExternal | Nice对外类， 通过NiceExternal的实例来调用接口。  |

### 示例

Nice关键词为请求接口路由的最后两个值。如果你想请求 https://nice.zebra-c.com/api/project/list 接口 ，那么你的key 应为 project_list

操作通过NiceExternal类完成，下面的代码创建一个NiceExternal对象，并完成调用:

```php
<?php
$accessKeyId = "<您从Nice获取的AccessKeyID>";
$accessKeySecret = "<您从Nice获取的AccessKeySecret>";
try {
    $key = "project_create"; //如果为创建项目接口，在接口文档中接口为： /api/project/create ；则在此处对应的 $key 为 project_create ，即剔除后两个斜杠后的内容以下划线拼接
    $data = ['project_name' => 'test', 'data_type' => '1']; //接口请求参数：请按照接口文档传入
    $niceExternal = new NiceExternal($accessKeyId, $accessKeySecret);
    $niceExternal->dealRequest($key, $data);
} catch (\Exception $e) {
    print $e->getErrorMessage();
}
```

### 运行单元测试

- 执行`composer install`下载依赖的库
- 设置环境变量

        export NICE_ACCESS_KEY_ID=access-key-id
        export NICE_ACCESS_KEY_SECRET=access-key-secret

- 执行 `php vendor/bin/phpunit`

## License

- MIT

## 联系我们

- [Nice综合管理平台](https://nice.zebra-c.com/storage/document/).


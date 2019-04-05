# laravel-admin-nocaptcha
laravel-admin 登陆集成 nocaptcha 

## 安装
**composer 安装**
 
```bash
composer require xiaohuilam/laravel-admin-nocaptcha
```

**更改 AuthController**
 
将你 `config('admin.auth.controller')` (通常为 `App\Admin\Controllers\AuthController`) 修改为继承自 `LaravelAdminExt\Nocaptcha\Controllers\AuthController`

从
```php
<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AuthController as BaseAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseAuthController
{
    //...
```

修改成
```php
<?php

namespace App\Admin\Controllers;

use LaravelAdminExt\Nocaptcha\Controllers\AuthController as BaseAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseAuthController
{
    //...
```

**配置 .env**
 
```env
RECAPTCHAV3_SITEKEY=#your recaptcha v3 sitekey
RECAPTCHAV3_SECRET=#your recaptcha v3 scret
RECAPTCHAV3_ORIGIN=https://www.recaptcha.net
```

## 演示

![screenshot.png](https://wantu-kw0-asset007-hz.oss-cn-hangzhou.aliyuncs.com/6XFwEaIPsSdHRu23Pg2.png)

## 授权
基于MIT开源

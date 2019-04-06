# laravel-admin-nocaptcha
laravel-admin 登陆集成 nocaptcha 

## 安装
**composer 安装**
 
```bash
composer require xiaohuilam/laravel-admin-nocaptcha
```

**初始化配置文件 `config/admin_nocaptcha.php`**

```bash
php artisan vendor:publish --tag=laravel-admin-nocaptcha
```

**更改 AuthController**
 
修改`App\Admin\Controllers\AuthController`继承类为 `LaravelAdminExt\Nocaptcha\Controllers\AuthController`

```php
<?php

namespace App\Admin\Controllers;

use LaravelAdminExt\Nocaptcha\Controllers\AuthController as BaseAuthController; // 修改这一行

class AuthController extends BaseAuthController
{
    //...
```

**配置 .env**
 
```env
RECAPTCHAV3_SITEKEY=#your recaptcha v3 sitekey
RECAPTCHAV3_SECRET=#your recaptcha v3 scret
RECAPTCHAV3_ORIGIN=https://www.recaptcha.net #For mainlan china user
RECAPTCHAV3_LOGIN_SCORE=0.3 #如果你需要修改验证分数, 修改这里就对了
```

## 演示

![screenshot.png](https://wantu-kw0-asset007-hz.oss-cn-hangzhou.aliyuncs.com/6XFwEaIPsSdHRu23Pg2.png)

## 授权

基于MIT开源

---

以下为英文说明

---

# laravel-admin-nocaptcha
nocaptcha(recaptcha v3) implment for laravel-admin login

## 安装
**composer install**
 
```bash
composer require xiaohuilam/laravel-admin-nocaptcha
```

**create `config/admin_nocaptcha.php` by command**

```bash
php artisan vendor:publish --tag=laravel-admin-nocaptcha
```

**change your AuthController**
 
edit `App\Admin\Controllers\AuthController`, set parent class to `LaravelAdminExt\Nocaptcha\Controllers\AuthController`

```php
<?php

namespace App\Admin\Controllers;

use LaravelAdminExt\Nocaptcha\Controllers\AuthController as BaseAuthController; // This line you'd edit to

class AuthController extends BaseAuthController
{
    //...
```

**change your .env**
 
```env
RECAPTCHAV3_SITEKEY=#your recaptcha v3 sitekey
RECAPTCHAV3_SECRET=#your recaptcha v3 scret
RECAPTCHAV3_LOGIN_SCORE=0.3 #Change only if you to adjust the score when validation is request from bot 
```

## Demo

![screenshot.png](https://wantu-kw0-asset007-hz.oss-cn-hangzhou.aliyuncs.com/6XFwEaIPsSdHRu23Pg2.png)

## License

Open source under [MIT license](LICENSE).

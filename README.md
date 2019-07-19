# laravel-admin-nocaptcha
nocaptcha(recaptcha v3) implment for laravel-admin login

[中文文档](README_cn.md)


[![travis.svg](https://img.shields.io/travis/com/xiaohuilam/laravel-admin-nocaptcha/master.svg?style=flat-square)](https://travis-ci.com/xiaohuilam/laravel-admin-nocaptcha)
[![styleci.svg](https://github.styleci.io/repos/179709246/shield?branch=master)](https://github.styleci.io/repos/179709246)
[![version.svg](https://img.shields.io/packagist/vpre/xiaohuilam/laravel-admin-nocaptcha.svg?style=flat-square)](https://packagist.org/packages/xiaohuilam/laravel-admin-nocaptcha)
[![issues-open.svg](https://img.shields.io/github/issues/xiaohuilam/laravel-admin-nocaptcha.svg?style=flat-square)](https://github.com/xiaohuilam/laravel-admin-nocaptcha/issues)
[![last-commit.svg](https://img.shields.io/github/last-commit/xiaohuilam/laravel-admin-nocaptcha.svg?style=flat-square)](https://github.com/xiaohuilam/laravel-admin-nocaptcha/commits/)
[![contributors.svg](https://img.shields.io/github/contributors/xiaohuilam/laravel-admin-nocaptcha.svg?style=flat-square)](https://github.com/xiaohuilam/laravel-admin-nocaptcha/graphs/contributors)
[![install-count.svg](https://img.shields.io/packagist/dt/xiaohuilam/laravel-admin-nocaptcha.svg?style=flat-square)](https://packagist.org/packages/xiaohuilam/laravel-admin-nocaptcha)
[![license.svg](https://img.shields.io/github/license/xiaohuilam/laravel-admin-nocaptcha.svg?style=flat-square)](LICENSE)

## 安装
**composer install**

```bash
composer require xiaohuilam/laravel-admin-nocaptcha
```

**create `config/admin_nocaptcha.php` by command**

```bash
php artisan vendor:publish --tag=laravel-admin-nocaptcha
```

**change your .env**

```env
RECAPTCHAV3_SITEKEY=#your recaptcha v3 sitekey
RECAPTCHAV3_SECRET=#your recaptcha v3 scret
RECAPTCHAV3_LOGIN_SCORE=0.3 #Change only if you to adjust the score when validation is request from bot
```

```env
RECAPTCHAV3_ORIGIN=#usually you needn't set this var, but china user needs.
```
## Demo

![screenshot.png](https://wantu-kw0-asset007-hz.oss-cn-hangzhou.aliyuncs.com/bJVb0m69U3bLO5e7Ymx.png?x-oss-process=image/resize,h_400)

## Donation
[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.me/laravel)

## License

Open source under [MIT license](LICENSE).

<?php

namespace LaravelAdminExt\Nocaptcha;

use Encore\Admin\Facades\Admin;
use Illuminate\Support\ServiceProvider;

class NocaptchaServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'laravel-admin-nocaptcha');

        $this->app->booted(function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });

        $this->publishes([
            __DIR__.'/../config/' => config_path(),
        ], 'laravel-admin-nocaptcha');
    }
}

<?php
namespace LaravelAdminExt\Nocaptcha;

use Illuminate\Support\ServiceProvider;
use Encore\Admin\Facades\Admin;

class NocaptchaServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'laravel-admin-nocaptcha');

        $this->app->booted(function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });

        $this->publishes([
            __DIR__ . '/../config/' => config_path(),
        ], 'laravel-admin-nocaptcha');
    }
}

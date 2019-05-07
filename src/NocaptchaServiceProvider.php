<?php

namespace LaravelAdminExt\Nocaptcha;

use Illuminate\Support\ServiceProvider;

class NocaptchaServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(Nocaptcha $extension)
    {
        if (!Nocaptcha::boot()) {
            return;
        }

        $this->loadViewsFrom($extension->views(), 'laravel-admin-nocaptcha');
        $this->mergeConfigFrom(__DIR__ . '/../config/admin_nocaptcha.php', 'admin_nocaptcha');

        $this->app->booted(function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });

        $this->publishes([
            __DIR__.'/../config/' => config_path(),
        ], 'laravel-admin-nocaptcha');
    }
}

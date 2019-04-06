<?php
namespace LaravelAdminExt\Nocaptcha;

use Illuminate\Support\ServiceProvider;

class NocaptchaServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'laravel-admin-nocaptcha');
        $this->publishes([
            __DIR__ . '/../config/' => config_path(),
        ], 'laravel-admin-nocaptcha');
    }
}

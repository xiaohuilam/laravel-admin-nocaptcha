<?php

namespace LaravelAdminExt\Nocaptcha\Tests;

use TestCase as BaseTestCase;
use Illuminate\Filesystem\Filesystem;
use Encore\Admin\AdminServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Illuminate\Database\Eloquent\Model;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
use LaravelAdminExt\Nocaptcha\NocaptchaServiceProvider;
use Lunaweb\RecaptchaV3\Providers\RecaptchaV3ServiceProvider;

abstract class AbstractTestCase extends BaseTestCase
{
    /**
     * Boots the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        /**
         * @var \Illuminate\Foundation\Application $app
         */
        $app = require __DIR__ . '/../vendor/laravel/laravel/bootstrap/app.php';

        $app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Admin', \Encore\Admin\Facades\Admin::class);
        });

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        $app->register(AdminServiceProvider::class);
        $app->register(RecaptchaV3ServiceProvider::class);
        $app->register(NocaptchaServiceProvider::class);
        if (!class_exists('RecaptchaV3')) {
            class_alias(RecaptchaV3::class, 'RecaptchaV3');
        }

        return $app;
    }

    public function setUp()
    {
        if (!$this->app) {
            $this->refreshApplication();
        }

        $this->setUpTraits();

        foreach ($this->afterApplicationCreatedCallbacks as $callback) {
            call_user_func($callback);
        }

        Facade::clearResolvedInstances();

        Model::setEventDispatcher($this->app['events']);

        $this->setUpHasRun = true;

        /**
         * @var \Illuminate\Config\Repository $config
         */
        $config = $this->app['config'];
        $config->set('app.debug', true);
        $config->set('database.default', 'sqlite');
        $config->set('database.connections.sqlite.database', ':memory:');
        $config->set('app.key', 'AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');
        $config->set('filesystems', require __DIR__ . '/../vendor/encore/laravel-admin/tests/config/filesystems.php');

        $file = require __DIR__ . '/config/recaptchav3.php';
        $config->set('recaptchav3', $file);

        $file = require __DIR__ . '/config/admin.php';
        $config->set('admin', $file);

        foreach (array_dot(array_get($file, 'auth'), 'auth.') as $key => $value) {
            $config->set($key, $value);
        }

        $this->artisan('vendor:publish', ['--provider' => AdminServiceProvider::class,]);
        $this->artisan('vendor:publish', ['--provider' => NocaptchaServiceProvider::class,]);

        $this->artisan('admin:install');

        $this->migrateTestTables();

        if (file_exists($routes = admin_path('routes.php'))) {
            require $routes;
        }
        require __DIR__ . '/../routes/web.php';

        require __DIR__ . '/../vendor/encore/laravel-admin/tests/seeds/factory.php';
    }

    public function tearDown()
    {
        (new \CreateAdminTables())->down();

        if ($this->app) {
            foreach ($this->beforeApplicationDestroyedCallbacks as $callback) {
                call_user_func($callback);
            }

            $this->app->flush();

            $this->app = null;
        }

        $this->setUpHasRun = false;

        if (property_exists($this, 'serverVariables')) {
            $this->serverVariables = [];
        }

        $this->afterApplicationCreatedCallbacks = [];
        $this->beforeApplicationDestroyedCallbacks = [];
    }
}

<?php
/*
 * This file is part of YourPackage.
 *
 * (c) Firstname Lastname <email@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace YourVendor\YourPackage;

use Illuminate\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

/**
 * This is the YourPackage service provider class.
 *
 * @author Firstname Lastname <email@email.com>
 */
class YourPackageServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;
    
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../config/your-package.php');
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('your-package.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('your-package');
        }
        $this->mergeConfigFrom($source, 'your-package');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerDummyClass();
    }

    /**
     * Register the auth factory class.
     *
     * @return void
     */
    protected function registerDummyClass()
    {
        $this->app->singleton('your-pacakage.dummyclass', function (Container $app) {
            return new DummyClass($app['config']);
        });
        $this->app->alias('your-pacakage.dummyclass', DummyClass::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return ['your-pacakage.dummyclass'];
    }
}
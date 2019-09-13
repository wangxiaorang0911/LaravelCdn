<?php

namespace SampleNinja\LaravelCdn;

use Illuminate\Support\ServiceProvider;

/**
 * Class CdnServiceProvider.
 *
 * @category Service Provider
 *
 * @author  Mahmoud Zalt <mahmoud@vinelab.com>
 * @author  Abed Halawi <abed.halawi@vinelab.com>
 */
class CdnServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '../config/cdn.php' => config_path('cdn.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        // implementation bindings:
        //-------------------------
        $this->app->bind(
            'SampleNinja\LaravelCdn\Contracts\CdnInterface',
            'SampleNinja\LaravelCdn\Cdn'
        );

        $this->app->bind(
            'SampleNinja\LaravelCdn\Providers\Contracts\ProviderInterface',
            'SampleNinja\LaravelCdn\Providers\AwsS3Provider'
        );

        $this->app->bind(
            'SampleNinja\LaravelCdn\Contracts\AssetInterface',
            'SampleNinja\LaravelCdn\Asset'
        );

        $this->app->bind(
            'SampleNinja\LaravelCdn\Contracts\FinderInterface',
            'SampleNinja\LaravelCdn\Finder'
        );

        $this->app->bind(
            'SampleNinja\LaravelCdn\Contracts\ProviderFactoryInterface',
            'SampleNinja\LaravelCdn\ProviderFactory'
        );

        $this->app->bind(
            'SampleNinja\LaravelCdn\Contracts\CdnFacadeInterface',
            'SampleNinja\LaravelCdn\CdnFacade'
        );

        $this->app->bind(
            'SampleNinja\LaravelCdn\Contracts\CdnHelperInterface',
            'SampleNinja\LaravelCdn\CdnHelper'
        );

        $this->app->bind(
            'SampleNinja\LaravelCdn\Validators\Contracts\ProviderValidatorInterface',
            'SampleNinja\LaravelCdn\Validators\ProviderValidator'
        );

        $this->app->bind(
            'SampleNinja\LaravelCdn\Validators\Contracts\CdnFacadeValidatorInterface',
            'SampleNinja\LaravelCdn\Validators\CdnFacadeValidator'
        );

        $this->app->bind(
            'SampleNinja\LaravelCdn\Validators\Contracts\ValidatorInterface',
            'SampleNinja\LaravelCdn\Validators\Validator'
        );

        // register the commands:
        //-----------------------
        $this->app->singleton('cdn.push', function ($app) {
            return $app->make('SampleNinja\LaravelCdn\Commands\PushCommand');
        });

        $this->commands('cdn.push');

        $this->app->singleton('cdn.empty', function ($app) {
            return $app->make('SampleNinja\LaravelCdn\Commands\EmptyCommand');
        });

        $this->commands('cdn.empty');

        // facade bindings:
        //-----------------

        // Register 'CdnFacade' instance container to our CdnFacade object
        $this->app->singleton('CDN', function ($app) {
            return $app->make('SampleNinja\LaravelCdn\CdnFacade');
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
//        $this->app->booting(function () {
//            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
//            $loader->alias('Cdn', 'SampleNinja\LaravelCdn\Facades\CdnFacadeAccessor');
//        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}

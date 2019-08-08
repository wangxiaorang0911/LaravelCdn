<?php

namespace Juhasev\laravelcdn;

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
            __DIR__.'/../../config/cdn.php' => config_path('cdn.php'),
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
            'Juhasev\laravelcdn\Contracts\CdnInterface',
            'Juhasev\laravelcdn\Cdn'
        );

        $this->app->bind(
            'Juhasev\laravelcdn\Providers\Contracts\ProviderInterface',
            'Juhasev\laravelcdn\Providers\AwsS3Provider'
        );

        $this->app->bind(
            'Juhasev\laravelcdn\Contracts\AssetInterface',
            'Juhasev\laravelcdn\Asset'
        );

        $this->app->bind(
            'Juhasev\laravelcdn\Contracts\FinderInterface',
            'Juhasev\laravelcdn\Finder'
        );

        $this->app->bind(
            'Juhasev\laravelcdn\Contracts\ProviderFactoryInterface',
            'Juhasev\laravelcdn\ProviderFactory'
        );

        $this->app->bind(
            'Juhasev\laravelcdn\Contracts\CdnFacadeInterface',
            'Juhasev\laravelcdn\CdnFacade'
        );

        $this->app->bind(
            'Juhasev\laravelcdn\Contracts\CdnHelperInterface',
            'Juhasev\laravelcdn\CdnHelper'
        );

        $this->app->bind(
            'Juhasev\laravelcdn\Validators\Contracts\ProviderValidatorInterface',
            'Juhasev\laravelcdn\Validators\ProviderValidator'
        );

        $this->app->bind(
            'Juhasev\laravelcdn\Validators\Contracts\CdnFacadeValidatorInterface',
            'Juhasev\laravelcdn\Validators\CdnFacadeValidator'
        );

        $this->app->bind(
            'Juhasev\laravelcdn\Validators\Contracts\ValidatorInterface',
            'Juhasev\laravelcdn\Validators\Validator'
        );

        // register the commands:
        //-----------------------
        $this->app->singleton('cdn.push', function ($app) {
            return $app->make('Juhasev\laravelcdn\Commands\PushCommand');
        });

        $this->commands('cdn.push');

        $this->app->singleton('cdn.empty', function ($app) {
            return $app->make('Juhasev\laravelcdn\Commands\EmptyCommand');
        });

        $this->commands('cdn.empty');

        // facade bindings:
        //-----------------

        // Register 'CdnFacade' instance container to our CdnFacade object
        $this->app->singleton('CDN', function ($app) {
            return $app->make('Juhasev\laravelcdn\CdnFacade');
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
//        $this->app->booting(function () {
//            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
//            $loader->alias('Cdn', 'Juhasev\laravelcdn\Facades\CdnFacadeAccessor');
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

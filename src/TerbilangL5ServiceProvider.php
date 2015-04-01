<?php namespace Riskihajar\Terbilang;

use Illuminate\Support\ServiceProvider;

class TerbilangL5ServiceProvider extends ServiceProvider {

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
        $this->loadTranslationsFrom(__DIR__ . '/../lib/lang', 'terbilang');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['terbilang'] = $this->app->share(function($app){
            return new Terbilang;
        });

        $this->app->booting(function(){
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Terbilang', 'Riskihajar\Terbilang\Facades\Terbilang');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('terbilang');
    }

}

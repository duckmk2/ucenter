<?php namespace Duckmk2\Ucenter;

use Illuminate\Support\ServiceProvider;

class UcenterServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/ucenter.php' => config_path('ucenter.php'),
        ]);

        $this->mergeConfigFrom(__DIR__.'/config/ucenter.php', 'ucenter');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ucenter', function ($app) {
            return new Ucenter;
        });

        $this->app->bind('Duckmk2\Ucenter\Contracts\Api', config('ucenter.service'));
    }
}

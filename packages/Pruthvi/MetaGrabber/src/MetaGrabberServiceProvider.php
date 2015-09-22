<?php

namespace Pruthvi\MetaGrabber;

use Illuminate\Support\ServiceProvider;

class MetaGrabberServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('metagrabber', function ($app) {
            return new MetaGrabber;
        });
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // loading the routes from the routes file.
        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/Http/routes.php';
        }

        $this->loadViewsFrom(__DIR__ . '/views', 'metagrabber');

        // publishing the migrations
        $this->publishes([
            __DIR__ . '/../config/metagrabber.php' => config_path('metagrabber.php'),
            __DIR__.'/assets' => public_path('assets/meta_grabber')
        ]);
    }
}

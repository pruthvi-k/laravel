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
//        $this->publishes([
//            __DIR__ . '/../database/migrations/2015_08_25_114208_create_chat_rooms_table.php' => base_path('database/migrations/2015_08_25_114208_create_chat_rooms_table.php'),
//            __DIR__.'/../assets' => public_path('assets')
//        ]);
    }
}

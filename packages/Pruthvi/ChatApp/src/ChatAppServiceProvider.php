<?php

namespace Pruthvi\ChatApp;

use Illuminate\Support\ServiceProvider;

class ChatAppServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('chatApp', function ($app) {
            return new ChatApp;
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

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'chatApp');

        // publishing the migrations
        $this->publishes([
            __DIR__ . '/../database/migrations/2015_08_25_114208_create_chat_rooms_table.php' => base_path('database/migrations/2015_08_25_114208_create_chat_rooms_table.php'),
            __DIR__.'/../assets' => public_path('assets')
        ]);
    }
}

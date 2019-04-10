<?php

namespace Jxd\Moon;

use Illuminate\Support\ServiceProvider;

class MoonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
        $this->loadMigrationsFrom(__DIR__.'/Migrations');
        $this->publishes([__DIR__.'/Controllers' => base_path('app/Http/Controllers')], 'controller');
        $this->publishes([__DIR__.'/Models' => base_path('app')], 'model');
    }
}

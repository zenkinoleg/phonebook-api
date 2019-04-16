<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\App\Services\AppStats::class, function () {
            return new \App\Services\AppStats();
        });
    }

    public function boot()
    {
/*
        app('config')->set('app.aliases', [
            'App' => 'Illuminate\Support\Facades\App',
        ]);
*/
    }
}

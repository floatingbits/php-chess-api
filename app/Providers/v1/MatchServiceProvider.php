<?php

namespace App\Providers\v1;
use App\Services\v1\MatchService;

use Illuminate\Support\ServiceProvider;
use Netsensia\Uci\Engine;

class MatchServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MatchService::class, function($app) {

            return new MatchService($this->app->make('Netsensia\Uci\Engine'));
        });
    }
}

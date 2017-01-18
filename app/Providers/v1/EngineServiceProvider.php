<?php
/**
 * This file contains only the class {@see unknown}
 * @author Sören Parton
 * @since 2017-01-13
 */


namespace App\Providers\v1;

use Illuminate\Support\ServiceProvider;
use Netsensia\Uci\Engine;


/**
 * Class EngineServiceProvider
 * 
 * @author Sören Parton
 */
class EngineServiceProvider extends ServiceProvider {
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
        $this->app->bind(Engine::class, function($app) {
            $engine = new Engine('/Users/soeren/Downloads/stockfish-8-mac/Mac/stockfish-8-64');
            $engine->setErrorLog('/Users/soeren/Sites/php-chess-api/storage/logs/chess-error.log');
            $engine->setOutputLog('/Users/soeren/Sites/php-chess-api/storage/logs/chess.log');
            $engine->setLogEngineOutput(true);
            $engine->setMode(Engine::MODE_TIME_MILLIS);
            $engine->setModeValue(1000);
            return $engine;
        });
    }
} 
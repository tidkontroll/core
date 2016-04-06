<?php

namespace Tidkontroll\Providers;

use Tidkontroll\Console\Commands\SeedCommand;
use Illuminate\Database\SeedServiceProvider as ServiceProvider;

class SeedServiceProvider extends ServiceProvider
{
    /**
     * Register the seed console command.
     *
     * @return void
     */
    protected function registerSeedCommand()
    {
        $this->app->singleton('command.seed', function ($app) {
            return new SeedCommand($app['db']);
        });
    }
}
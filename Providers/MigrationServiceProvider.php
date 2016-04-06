<?php

namespace Tidkontroll\Providers;

use Tidkontroll\Handlers\SeedHandler;
use Tidkontroll\Handlers\MigrationHandler;
use Tidkontroll\Database\Migrations\Migrator;
use Illuminate\Database\MigrationServiceProvider as ServiceProvider;

class MigrationServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('migration.handler', function ($app) {
            return new MigrationHandler($app, collect());
        });

        $this->app->singleton('seed.handler', function ($app) {
            return new SeedHandler($app, collect());
        });

        parent::register();
    }

    /**
     * Register the migrator service.
     *
     * @return void
     */
    protected function registerMigrator()
    {
        // The migrator is responsible for actually running and rollback the migration
        // files in the application. We'll pass in our database connection resolver
        // so the migrator can resolve any of these connections when it needs to.
        $this->app->singleton('migrator', function ($app) {
            $repository = $app['migration.repository'];

            return new Migrator($repository, $app['db'], $app['files']);
        });
    }
}
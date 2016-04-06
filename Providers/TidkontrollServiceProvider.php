<?php

namespace Tidkontroll\Providers;

class TidkontrollServiceProvider extends AggregateServiceProvider
{
    /**
     * Holds all service providers we want to register
     *
     * @var array
     */
    protected $providers = [
        MigrationServiceProvider::class,
        \Tidkontroll\Theme\Providers\ThemeServiceProvider::class
    ];

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        require_once __DIR__.'/../Http/routes.php';

        $this->publishes([
            __DIR__.'/../Resources/Config' => config_path('tidkontroll')
        ], 'config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $this->app['migration.handler']
            ->migrate(__DIR__.'/../Resources/Migrations')
            ->using('Tidkontroll\Resources\Migrations')
            ->register();

        $this->app['seed.handler']->register(
            \Tidkontroll\Resources\Seeds\DatabaseSeeder::class
        );
    }
}

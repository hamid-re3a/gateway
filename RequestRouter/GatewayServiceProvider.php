<?php
namespace RequestRouter;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class GatewayServiceProvider extends ServiceProvider
{
    private $namespace = 'RequestRouter\Http\Controllers';

    public function register()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        if ($this->shouldMigrate()) {
            $this->loadMigrationsFrom([
                __DIR__ . '/database/migrations',
            ]);
        }
        $this->publishes([
            __DIR__ . '/database/migrations' => database_path('migrations'),
        ], 'request-router-migrations');
        $this->publishes([
            __DIR__ . '/database/seeders/' => database_path('seeders'),
        ], 'request-router-seeds');

        $this->publishes([
            __DIR__.'/config/gateway.php' => config_path('gateway.php'),
        ], 'request-router-config');
        $this->publishes([
            __DIR__ . '/resources/lang' => resource_path('lang'),
        ], 'request-router-resources');
    }
    public function boot()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__.'/routes/api.php');

        $this->registerHelpers();

        if ($this->app->runningInConsole()) {
            $this->seed();
        }

        JsonResource::withoutWrapping();
    }

    /**
     * Register helpers.
     */
    protected function registerHelpers()
    {
        if (file_exists($helperFile = __DIR__ . '/helpers/constants.php')) {
            require_once $helperFile;
        }

        if (file_exists($helperFile = __DIR__ . '/helpers/functions.php')) {
            require_once $helperFile;
        }
    }

    /**
     * Determine if we should register the migrations.
     *
     * @return bool
     */
    protected function shouldMigrate(): bool
    {
        return GatewayConfigure::$runsMigrations;
    }

    private function seed()
    {
        if (isset($_SERVER['argv']))
            if (array_search('db:seed', $_SERVER['argv'])) {
                GatewayConfigure::seed();
            }
    }


}

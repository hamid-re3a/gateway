<?php
namespace RequestRouter;

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



}

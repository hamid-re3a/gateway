<?php

namespace ApiGatewayUser;

use Illuminate\Support\Facades\Artisan;
use ApiGatewayUser\Models\User;
use ApiGatewayUser\Observers\UserObserver;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    private $namespace = 'ApiGatewayUser\Http\Controllers';

    public function register()
    {


        if (!$this->app->runningInConsole()) {
            return;
        }
        if ($this->shouldMigrate()) {
            $this->loadMigrationsFrom([
                __DIR__ . '/database/migrations',
            ]);
        }
        $this->publishes([
            __DIR__ . '/database/migrations' => database_path('migrations'),
        ], 'r2f-user-migrations');
        $this->publishes([
            __DIR__ . '/database/seeders/' => database_path('seeders'),
        ], 'r2f-user-seeds');
    }

    public function boot()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/routes/api.php');

        if ($this->app->runningInConsole()) {
            if (isset($_SERVER['argv']))
                if (array_search('db:seed', $_SERVER['argv']))
                    Artisan::call('db:seed', ['--class' => "ApiGatewayUser\database\seeders\AuthTableSeeder"]);
        }
        User::observe(UserObserver::class);

    }


    /**
     * Determine if we should register the migrations.
     *
     * @return bool
     */
    protected function shouldMigrate(): bool
    {
        return UserConfigure::$runsMigrations;
    }


}

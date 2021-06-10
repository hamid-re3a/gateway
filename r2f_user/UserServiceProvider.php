<?php
namespace R2FUser;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    private $namespace = 'R2FUser\Http\Controllers';

    public function register()
    {
    }
    public function boot()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__.'/routes/api.php');
    }
}

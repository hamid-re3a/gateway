<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::any('/gateway/{any?}', [\R2FUser\Http\Controllers\Front\UserController::class,'aggregate'])->where('any', '.*');;
////Admin
//Route::prefix('admin')->middleware(['api', 'auth', 'role:admin|help-desk'])->group(function () {
//
//
//});

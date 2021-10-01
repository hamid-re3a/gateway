<?php

use Illuminate\Support\Facades\Route;
use RequestRouter\Http\Controllers\GatewayServicesController;

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

Route::middleware(['role:super-admin|user-gateway-admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::prefix('gateway_service')->name("gateway-service")->group(function () {
        Route::get('/list', [GatewayServicesController::class, 'gatewayServicesList'])->name('list');
        Route::post('/edit', [GatewayServicesController::class, 'editServiceGateway'])->name('edit');
    });

});


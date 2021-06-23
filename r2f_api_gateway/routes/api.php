<?php

use R2FGateway\Http\Controllers\GatewayController;
use Illuminate\Support\Facades\Route;

Route::middleware(['user_activity','block_user'])->group(function () {
    Route::any('/gateway/{any?}', [GatewayController::class,'aggregate'])->where('any', '.*');;
});

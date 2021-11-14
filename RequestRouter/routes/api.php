<?php

use RequestRouter\Http\Controllers\GatewayController;
use Illuminate\Support\Facades\Route;

Route::middleware(['user_activity','block_user','token_passed_2fa'])->group(function () {
    Route::any('/gateway/multi/{any?}', [GatewayController::class,'multiAggregate'])->where('any', '.*');;
    Route::any('/gateway/{any?}', [GatewayController::class, 'requestRouter'])->where('any', '.*');;
});

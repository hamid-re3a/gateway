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

Route::get('all_settings',[\App\Http\Controllers\SettingController::class,'index'])->name('all-settings');
////Admin
//Route::prefix('admin')->middleware(['api', 'auth', 'role:admin|help-desk'])->group(function () {
//
//
//});

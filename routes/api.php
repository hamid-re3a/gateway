<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Front\CommentController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Front\KYCController as FrontKYCControllerAlias;
use App\Http\Controllers\Front\TicketController as FrontTicketController;
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

Route::name('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/user', [AuthController::class, 'getAuthUser'])->name('current-user');
});

Route::middleware(['auth'])->group(function () {
    Route::post('kyc/upload', [FrontKYCControllerAlias::class, 'uploadDocuments'])->name('kyc-upload-file');
});
////Admin
//Route::prefix('admin')->middleware(['api', 'auth', 'role:admin|help-desk'])->group(function () {
//
//
//});

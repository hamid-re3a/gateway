<?php

use Illuminate\Support\Facades\Route;
use R2FUser\Http\Controllers\Front\AuthController;
use R2FUser\Http\Controllers\Front\KYCController as FrontKYCControllerAlias;
use R2FUser\Http\Controllers\Front\LoginSecurityController;

Route::middleware(['user_activity'])->group(function () {
    Route::name('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware(['login_attempt']);
        Route::post('/forget_password', [AuthController::class, 'forgetPassword'])->name('forget-password');
    });


    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/user', [AuthController::class, 'getAuthUser'])->name('current-user');

        Route::post('/generate2fa_secret', [LoginSecurityController::class, 'generate2faSecret'])->name('2fa-secret');
        Route::post('/generate2fa_enable', [LoginSecurityController::class, 'enable2fa'])->name('2fa-enable');
        Route::post('/generate2fa_disable', [LoginSecurityController::class, 'disable2fa'])->name('2fa-disable')->middleware(['2fa']);

        Route::put('kyc/upload', [FrontKYCControllerAlias::class, 'uploadDocuments'])->name('kyc-upload-file');
    });
});

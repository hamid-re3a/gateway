<?php

use Illuminate\Support\Facades\Route;
use R2FUser\Http\Controllers\Front\AuthController;
use R2FUser\Http\Controllers\Front\KYCController as FrontKYCControllerAlias;

Route::name('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/user', [AuthController::class, 'getAuthUser'])->name('current-user');
    Route::get('/forget_password', [AuthController::class, 'forgetPassword'])->name('forget-password');
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('kyc/upload', [FrontKYCControllerAlias::class, 'uploadDocuments'])->name('kyc-upload-file');
});

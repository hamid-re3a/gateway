<?php

use Illuminate\Support\Facades\Route;
use R2FUser\Http\Controllers\Admin\UserController as AdminUserController;
use R2FUser\Http\Controllers\Front\AuthController;
use R2FUser\Http\Controllers\Front\KYCController as FrontKYCControllerAlias;
use R2FUser\Http\Controllers\Front\LoginSecurityController;
use R2FUser\Http\Controllers\Front\UserController;

Route::middleware(['user_activity'])->group(function () {
    Route::name('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->name('register');
    });

    Route::middleware(['block_user'])->group(function () {
        Route::name('auth')->group(function () {
            Route::post('/is_username_exists', [AuthController::class, 'isUsernameExists'])->name('is-username-exists');
            Route::post('/is_email_exists', [AuthController::class, 'isEmailExists'])->name('is-email-exists');
            Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware(['login_attempt']);
            Route::post('/get_email_verify_token', [AuthController::class, 'askForEmailVerificationOtp'])->name('ask-for-email-otp');
            Route::post('/verify_email_token', [AuthController::class, 'verifyEmailOtp'])->name('verify-email-otp');
            Route::post('/forgot_password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
            Route::post('/reset_forgot_password', [AuthController::class, 'resetForgetPassword'])->name('reset-forgot-password');
        });
        Route::middleware(['auth:sanctum'])->group(function () {
            Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('/ping', [AuthController::class, 'ping'])->name('ping');
        });
        Route::middleware(['auth:sanctum', 'email_verified'])->group(function () {

            Route::middleware(['role:admin'])->prefix('admin')->group(function () {
                Route::post('/activate_or_deactivate_user', [AdminUserController::class, 'activateOrDeactivateUserAccount'])->name('activate-or-deactivate-user-account');

                Route::post('/verify_email_user', [AdminUserController::class, 'verifyUserEmailAccount'])->name('verify-email-user-account');
                Route::get('/user_email_verification_history', [AdminUserController::class, 'emailVerificationHistory'])->name('user-email-verification-history');
                Route::get('/user_login_history', [AdminUserController::class, 'loginHistory'])->name('user-login-history');
                Route::get('/user_block_history', [AdminUserController::class, 'blockHistory'])->name('user-block-history');
                Route::get('/user_password_history', [AdminUserController::class, 'passwordHistory'])->name('password-history');

            });
            Route::get('/user', [AuthController::class, 'getAuthUser'])->name('current-user');


            Route::post('/generate2fa_secret', [LoginSecurityController::class, 'generate2faSecret'])->name('2fa-secret');
            Route::post('/generate2fa_enable', [LoginSecurityController::class, 'enable2fa'])->name('2fa-enable');
            Route::post('/generate2fa_disable', [LoginSecurityController::class, 'disable2fa'])->name('2fa-disable')->middleware(['2fa']);

            Route::put('kyc/upload', [FrontKYCControllerAlias::class, 'uploadDocuments'])->name('kyc-upload-file');
        });
    });
});

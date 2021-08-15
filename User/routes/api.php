<?php

use Illuminate\Support\Facades\Route;
use User\Http\Controllers\Admin\TranslateController;
use User\Http\Controllers\Admin\UserController as AdminUserController;
use User\Http\Controllers\Front\ActivityController;
use User\Http\Controllers\Front\AuthController;
use User\Http\Controllers\Front\LoginSecurityController;
use User\Http\Controllers\Front\SessionController;
use User\Http\Controllers\Front\SettingController;
use User\Http\Controllers\Front\UserController;
use User\Http\Controllers\Front\WalletController;

Route::middleware(['user_activity'])->group(function () {

    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::middleware(['block_user'])->group(function () {
        Route::name('auth.')->group(function () {
            Route::post('/is_username_exists', [AuthController::class, 'isUsernameExists'])->name('is-username-exists');
            Route::post('/is_email_exists', [AuthController::class, 'isEmailExists'])->name('is-email-exists');
            Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware(['login_attempt']);
            Route::post('/get_email_verify_token', [AuthController::class, 'askForEmailVerificationOtp'])->name('ask-for-email-otp');
            Route::post('/verify_email_token', [AuthController::class, 'verifyEmailOtp'])->name('verify-email-otp');
            Route::post('/forgot_password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
            Route::post('/reset_forgot_password', [AuthController::class, 'resetForgetPassword'])->name('reset-forgot-password');
        });

        Route::get('all_settings',[SettingController::class,'index'])->name('all-settings');

        Route::middleware(['auth', 'email_verified'])->group(function () {
            Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('/ping', [AuthController::class, 'ping'])->name('ping');

            Route::get('/user', [AuthController::class, 'getAuthUser'])->name('current-user');


            Route::post('/generate2fa_secret', [LoginSecurityController::class, 'generate2faSecret'])->name('2fa-secret');
            Route::post('/generate2fa_enable', [LoginSecurityController::class, 'enable2fa'])->name('2fa-enable');
            Route::post('/generate2fa_disable', [LoginSecurityController::class, 'disable2fa'])->name('2fa-disable')->middleware(['2fa']);


            Route::get('/sessions/all', [SessionController::class, 'index'])->name('sessions-history');
            Route::post('/sessions/signout', [SessionController::class, 'signout'])->name('session-logout');
            Route::post('/sessions/signout-all-others', [SessionController::class, 'signOutAllOtherSessions'])->name('session-other-sessions');


            Route::prefix('profile_management')->group(function(){
                Route::post('change_password', [UserController::class, 'changePassword'])->name('change-password');
                Route::post('change_transaction_password', [UserController::class, 'changeTransactionPassword'])->name('change-transaction-password');
                Route::get('transaction_password_otp', [UserController::class, 'askTransactionPasswordOtp'])->name('ask-transaction-password-otp');
                Route::post('verify_transaction_otp', [UserController::class, 'verifyTransactionPasswordOtp'])->name('verify-transaction-password-otp');
                Route::post('update_personal_details', [UserController::class, 'updatePersonalDetails'])->name('update-personal-details');
                Route::post('update_avatar', [UserController::class, 'updateAvatar'])->name('update-avatar');
                Route::get('avatar', [UserController::class, 'getAvatar'])->name('get-avatar');
                Route::post('freeze', [UserController::class, 'freeze'])->name('freeze-account');
                Route::post('unfreeze', [UserController::class, 'unfreeze'])->name('unfreeze-account');
            });

            Route::prefix('wallets')->group(function(){
                Route::get('/available_crypto_currencies', [WalletController::class, 'availableCryptoCurrencies'])->name('wallets-available-crypto-currencies');
                Route::post('/', [WalletController::class, 'add'])->name('wallets-add');
                Route::patch('/update-wallet', [WalletController::class, 'updateWallet'])->name('wallets-update');
                Route::get('all', [WalletController::class, 'index'])->name('wallets-list');
                Route::get('active', [WalletController::class, 'activeWallets'])->name('wallets-actives-list');
                Route::get('inactive', [WalletController::class, 'inactiveWallets'])->name('wallets-inactive-list');
            });

            Route::prefix('translates')->name('translates.')->group(function(){
                Route::get('/', [TranslateController::class, 'index'])->name('list');
                Route::get('/unfinished', [TranslateController::class, 'unfinished'])->name('unfinished');
                Route::post('/show', [TranslateController::class, 'show'])->name('show');
                Route::post('/store', [TranslateController::class, 'store'])->name('store');
                Route::patch('/update', [TranslateController::class, 'update'])->name('update');
                Route::delete('/delete', [TranslateController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('activities')->name('activities.')->group(function() {
                Route::get('/', [ActivityController::class, 'index'])->name('full-list');
            });

            Route::middleware(['role:admin'])->name('admin.')->prefix('admin')->group(function () {
                Route::post('/activate_or_deactivate_user', [AdminUserController::class, 'activateOrDeactivateUserAccount'])->name('activate-or-deactivate-user-account');

                Route::post('/verify_email_user', [AdminUserController::class, 'verifyUserEmailAccount'])->name('verify-email-user-account');
                Route::get('/user_email_verification_history', [AdminUserController::class, 'emailVerificationHistory'])->name('user-email-verification-history');
                Route::get('/user_login_history', [AdminUserController::class, 'loginHistory'])->name('user-login-history');
                Route::get('/user_block_history', [AdminUserController::class, 'blockHistory'])->name('user-block-history');
                Route::get('/user_password_history', [AdminUserController::class, 'passwordHistory'])->name('password-history');

            });
        });
    });
});

<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Front\CommentController;
use App\Http\Controllers\Admin\TicketController;
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
    Route::get('/user', [AuthController::class, 'getAuthUser']);
});

Route::middleware(['auth'])->group(function () {

    Route::resource('tickets', FrontTicketController::class)->only(array('index', 'store', 'show'));
    Route::post('ticket/comment', [CommentController::class, 'sendCommentTicket'])->name('comment');

});
//Admin
Route::prefix('admin')->middleware(['api', 'auth', 'role:admin|help-desk'])->group(function () {

    //Admin Ticket
    Route::get('/tickets', [TicketController::class, 'index'])->name('admin.tickets');
    Route::post('/tickets/comment', [TicketController::class, 'replyComment'])->name('admin.reply.comment');
    Route::post('/tickets/change_status', [TicketController::class, 'changeTicketStatus'])->name('admin.ticket.status');
    Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('admin.show.ticket');

});

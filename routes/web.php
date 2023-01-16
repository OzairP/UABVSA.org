<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LotusReservationsController;
use App\Http\Controllers\RedirectionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', static fn() => view('welcome'))
     ->name('home');

Route::get('/auth/redirect', [AuthController::class, 'discord_redirect'])
     ->name('auth.redirect');
Route::get('/auth/callback', [AuthController::class, 'discord_callback'])
     ->name('auth.callback');

Route::get('/lotus2023', [LotusReservationsController::class, 'index'])
     ->name('lotus.index');

Route::post('/lotus2023/reserve', [LotusReservationsController::class, 'reserve'])
     ->name('lotus.reserve');

Route::get('/lotus2023/verification/complete', [LotusReservationsController::class, 'completeVerification'])
     ->name('lotus.verification.complete');

Route::get('/lotus2023/payment/success', [LotusReservationsController::class, 'paymentSuccess'])
     ->name('lotus.payment.success');

Route::get('/lotus2023/payment/cancel', [LotusReservationsController::class, 'paymentCancel'])
     ->name('lotus.payment.cancel');

Route::get('/lotus2023/donate', [LotusReservationsController::class, 'donate'])
     ->name('lotus.donate');

Route::get('/lotus2023/donate/success', [LotusReservationsController::class, 'donationSuccess'])
     ->name('lotus.donate.success');

Route::get('/{redirection:slug}', [RedirectionController::class, 'redirect']);

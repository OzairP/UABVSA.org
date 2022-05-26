<?php

use App\Enums\DiscordRole;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RedirectionController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', static fn() => view('welcome'));

Route::get('/auth/redirect', [AuthController::class, 'discord_redirect']);
Route::get('/auth/callback', [AuthController::class, 'discord_callback']);

Route::get('/test', function () {
    dd(Auth::user()->isAdmin());
});

Route::get('/{redirection:slug}', [RedirectionController::class, 'redirect']);

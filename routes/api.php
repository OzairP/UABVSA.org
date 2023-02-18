<?php

use App\Http\Controllers\Api\Lotus\LotusApiController;
use Illuminate\Http\Request;
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

Route::group([
    'prefix' => 'lotus/reservation',
    'middleware' => 'auth.lotus',
], static function () {
    Route::get('/{lotusReservation}', [LotusApiController::class, 'show'])
         ->name('api.lotus.show');

    Route::post('/{lotusReservation}/check-in', [LotusApiController::class, 'checkIn'])
         ->name('api.lotus.check-in');
});

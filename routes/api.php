<?php

use App\Http\Controllers\Api\WeatherController;
use App\Http\Controllers\Api\StatsController;
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

Route::prefix('v1')
    ->name('api.')
    ->group(function () {

        Route::get('weather/{city}', [WeatherController::class, 'index']);
        Route::get('stats', [StatsController::class, 'index']);
    });

Route::fallback(function(){
    return response()->json(['message' => 'Not Found'], 404);
});

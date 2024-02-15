<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\OpenMeteoForecastController;
use App\Http\Controllers\WeatherApiForecastController;
use App\Http\Controllers\WeatherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::resource('weather-api', WeatherApiForecastController::class)->only([
    'index', 'show'
]);

Route::resource('open-meteo', OpenMeteoForecastController::class)->only([
    'index', 'show'
]);

Route::resource('location', LocationController::class)->except([
    'create', 'edit'
]);

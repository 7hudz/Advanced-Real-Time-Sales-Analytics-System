<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::post('/orders', [ApiController::class, 'addOrder']);
Route::get('/analytics', [ApiController::class, 'getAnalytics']);
Route::get('/get-recommendations', [ApiController::class, 'getRecommendations']);
Route::get('/weather-recommendations', [ApiController::class, 'getWeatherRecommendations']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

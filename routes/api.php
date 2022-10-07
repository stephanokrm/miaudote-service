<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:api')->group(function () {
    Route::get('/user/me', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('interest', InterestController::class);
    Route::apiResource('user', UserController::class)->except('store');
    Route::apiResource('animal', AnimalController::class)->except('index', 'show');
});

Route::apiResource('user', UserController::class)->only('store');
Route::apiResource('animal', AnimalController::class)->only('index', 'show');

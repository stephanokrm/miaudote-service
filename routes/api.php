<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\BreedController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\UserController;
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
    Route::get('/user/me', [UserController::class, 'me']);
    Route::post('/user/logout', [UserController::class, 'logout']);
    Route::get('/animal/me', [AnimalController::class, 'me']);
    Route::get('/interest/me', [InterestController::class, 'me']);

    Route::apiResource('animal', AnimalController::class)->except('index', 'show');
    Route::apiResource('animal.image', ImageController::class)->only('index', 'store');
    Route::apiResource('animal.interest', InterestController::class)->only('store');
    Route::apiResource('breed', BreedController::class);
    Route::apiResource('image', ImageController::class)->only('destroy');
    Route::apiResource('interest', InterestController::class)->except('store');
    Route::apiResource('user', UserController::class)->except('store');
});

Route::apiResource('animal', AnimalController::class)->only('index', 'show');
Route::apiResource('user', UserController::class)->only('store');

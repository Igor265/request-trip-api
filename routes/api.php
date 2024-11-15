<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderTripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('request-trip')->group(function() {
        Route::post('/', [OrderTripController::class, 'store']);
        Route::get('/', [OrderTripController::class, 'index']);
        Route::get('{id}', [OrderTripController::class, 'show']);
        Route::put('{id}/status', [OrderTripController::class, 'updateStatus']);
    });
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

<?php

use App\Http\Controllers\Api\HealthCheckController;
use App\Http\Controllers\Api\UserExternalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::get('health', [HealthCheckController::class, 'health']);
    Route::apiResource('users', UserExternalController::class);
});

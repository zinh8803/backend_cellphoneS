<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Admin\AuthController;
use L5Swagger\Http\Controllers\SwaggerController;
use App\Http\Controllers\ApiDocController;

Route::get('/api/documentation', [SwaggerController::class, 'api'])->name('swagger.docs');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth routes
Route::prefix('auth')->group(function () {
    Route::get('users', [AuthController::class, 'getAllUser']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
});

// Dummy ping endpoint for Swagger PathItem
Route::get('/ping', [ApiDocController::class, 'ping']);

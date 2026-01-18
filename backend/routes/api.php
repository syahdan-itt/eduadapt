<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\Admin\SubjectController;

Route::post('/auth/register', [AuthController::class, 'register'])->middleware('throttle:5,1');
Route::post('/auth/login', [AuthController::class, 'login'])->middleware('throttle:10,1');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', function (Request $request) {
        return $request->user();
    });

    Route::middleware('role:1')->prefix('admin')->group(function () {

        Route::prefix('subject')->group(function () {
            Route::get('/', [SubjectController::class, 'index']);
            Route::get('/{id}', [SubjectController::class, 'show']);
        });

        // Route::get('/materials', [MaterialController::class, 'index']);
        // Route::get('/materials/{id}', [MaterialController::class, 'show']);
        // Route::post('/materials', [MaterialController::class, 'store']);
        // Route::put('/materials/{id}', [MaterialController::class, 'update']);
        // Route::delete('/materials/{id}', [MaterialController::class, 'destroy']);
    });

    Route::middleware('role:2')->group(function () {

    });
});

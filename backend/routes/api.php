<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\Admin\SubjectController;
use App\Http\Controllers\Users\SubjectController;
use App\Http\Controllers\Users\QuizController;

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

        // Generate AI Content
        Route::post('/materials/{id}/generate-adaptive', [MaterialController::class, 'generateAdaptive']);
    });

    Route::middleware('role:2')->group(function () {
        Route::get('/materials', [MaterialController::class, 'index']);
    });

    Route::middleware('role:2')->prefix('user')->group(function () {
        // Subject
        Route::get('/subjects', [SubjectController::class, 'index']);
        Route::get('/subjects/{id}', [SubjectController::class, 'show']);

        // Quiz 
        Route::get('/quizzes', [QuizController::class, 'index']);
        Route::post('/quizzes/answer', [QuizController::class, 'answerQuiz']);
        Route::get('/quizzes/result', [QuizController::class, 'getQuizResult']);
    });
});

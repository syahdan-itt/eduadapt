<?php

use App\Http\Controllers\Admin\MaterialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Users\SubjectController as UserSubjectController;
use App\Http\Controllers\Users\QuizController;
use App\Http\Controllers\Admin\SubjectController;


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', function (Request $request) {
        return $request->user();
    });
    
    Route::middleware('role:1')->prefix('admin')->group(function () {
        Route::get('/materials', [MaterialController::class, 'index']);
        Route::get('/materials/{id}', [MaterialController::class, 'show']);
        Route::post('/materials', [MaterialController::class, 'store']);
        Route::put('/materials/{id}', [MaterialController::class, 'update']);
        Route::delete('/materials/{id}', [MaterialController::class, 'destroy']);

        Route::prefix('subject')->group(function () {
           Route::get('/', [SubjectController::class, 'index']);
           Route::get('/{id}', [SubjectController::class, 'show']);
           Route::post('/', [SubjectController::class, 'store']);
           Route::put('/{id}', [SubjectController::class, 'update']);
           Route::delete('/{id}', [SubjectController::class, 'destroy']);
        });
    });

    Route::middleware('role:2')->group(function () {
        Route::get('/materials', [UserSubjectController::class, 'index']);
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

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});
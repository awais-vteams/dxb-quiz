<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('quiz')->group(function () {
        Route::get('/start', [QuizController::class, 'startQuiz'])->name('quiz.start');
        Route::get('/result', [QuizController::class, 'result'])->name('quiz.result');
        Route::post('/skip', [QuizController::class, 'skipQuestion'])->name('quiz.skip');
        Route::post('/submit', [QuizController::class, 'submit'])->name('quiz.submit');
        Route::get('/question', [QuizController::class, 'question'])->name('quiz.question');
    });

    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');

    Route::post('login', [LoginController::class, 'store']);
});


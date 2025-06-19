<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ResultController;

// Public routes
Route::get('/', [CourseController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');
    
    Route::get('/videos/{id}', [VideoController::class, 'show'])->name('videos.show');
    Route::post('/progress/update', [ProgressController::class, 'update'])->name('progress.update');
    
    Route::post('/questions/{id}/answer', [VideoController::class, 'submitAnswer'])->name('questions.answer');
    Route::get('/results/{video_id}', [ResultController::class, 'show'])->name('results.show');
});
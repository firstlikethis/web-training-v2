<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\QuestionController;

// Public routes
Route::get('/', [CourseController::class, 'featured'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Route สำหรับ logout (ต้องการ auth)
Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');
    
    Route::get('/videos/{id}', [VideoController::class, 'show'])->name('videos.show');
    Route::post('/progress/update', [ProgressController::class, 'update'])->name('progress.update');
    
    // เพิ่ม route สำหรับการดึงข้อมูลคำถาม
    Route::get('/questions/{id}', [QuestionController::class, 'getQuestion'])->name('questions.get');
    Route::post('/questions/{id}/answer', [VideoController::class, 'submitAnswer'])->name('questions.answer');
    Route::post('/questions/{id}/check', [QuestionController::class, 'checkAnswer'])->name('questions.check');
    
    Route::get('/results/{video_id}', [ResultController::class, 'show'])->name('results.show');
});
 
require __DIR__.'/admin.php';
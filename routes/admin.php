<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\QuestionController;

// Admin routes
Route::prefix('dashboard-z2X9a')->group(function () {
    // Authentication
    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Protected admin routes
    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [AuthController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
        
        // Users management
        Route::resource('users', UserController::class);
        
        // Categories management
        Route::resource('categories', CategoryController::class);
        
        // Courses management
        Route::resource('courses', CourseController::class);
        
        // Videos management
        Route::resource('videos', VideoController::class);
        
        // Questions management
        Route::get('/videos/{video_id}/questions', [QuestionController::class, 'index'])->name('admin.questions.index');
        Route::get('/videos/{video_id}/questions/create', [QuestionController::class, 'create'])->name('admin.questions.create');
        Route::post('/videos/{video_id}/questions', [QuestionController::class, 'store'])->name('admin.questions.store');
        Route::get('/questions/{id}/edit', [QuestionController::class, 'edit'])->name('admin.questions.edit');
        Route::put('/questions/{id}', [QuestionController::class, 'update'])->name('admin.questions.update');
        Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->name('admin.questions.destroy');
    });
});
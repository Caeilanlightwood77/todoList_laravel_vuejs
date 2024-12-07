<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\SocialLoginController;

// Google OAuth Routes
Route::get('/auth/google/redirect', [SocialLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [SocialLoginController::class, 'handleGoogleCallback']);

// Welcome Page Route
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Dashboard Route
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Management Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// To-Do List Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Render To-Do List Page
    Route::get('/todo', function () {
        return Inertia::render('TodoList');
    })->name('todo');

    // API Routes for Task Management
    Route::get('/api/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/api/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::delete('/api/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Routes for editing and updating tasks
    Route::get('/api/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/api/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
});


// Authentication Routes
require __DIR__ . '/auth.php';


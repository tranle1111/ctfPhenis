<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FirebaseController;
use App\Http\Middleware\FirebaseAuthMiddleware;

/* 🔹 Authentication Routes */
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* 🔹 Redirect to Home or Login */
Route::get('/', function () {
    return session()->has('firebase_user') ? redirect()->route('home') : redirect()->route('login');  
});

/* 🔹 Authenticated User Pages */
Route::middleware([FirebaseAuthMiddleware::class])->group(function () {
    Route::get('/home', function () {
        return view('auth.home');
    })->name('home');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /* 🔹 Page Routes */
    Route::get('/rules', [PageController::class, 'rules'])->name('rules');
    Route::get('/teams', [PageController::class, 'teams'])->name('teams');
    Route::get('/scoreboard', [PageController::class, 'scoreboard'])->name('scoreboard');

    /* 🔹 Challenge Routes */
    Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges');
    Route::get('/challenges/{category}/{challengeName}', [ChallengeController::class, 'show'])->name('challenges.show');
    Route::get('/fetch-challenges', [ChallengeController::class, 'getChallenges'])->name('challenges.fetch');

    /* 🔹 Admin - Chỉ Admin mới truy cập */
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
        Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
        
        // Route upload chỉ dành cho Admin
        Route::post('/upload-challenges', [FirebaseController::class, 'uploadChallengesJson'])->name('upload-challenges');
    });
});

/* 🔹 Forgot Password */
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/challenges/check', [ChallengeController::class, 'checkAnswer'])->name('challenges.check');
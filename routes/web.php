<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

// route::get('/register', [AuthController::class, 'index']);
// Route::get('/register', [AuthController::class,'register']);
route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
route::get('/register', [AuthController::class, 'index'])->name('register');
route::post('/register', [AuthController::class, 'store']);

Route::post('/login', [AuthController::class,'login']);

Route::get('/posts', function () {
    // return view('welcome');
    return view('posts.index');
});

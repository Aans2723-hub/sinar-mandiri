<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\AuthController;

// --- RUTE PUBLIK (Bisa diakses siapa saja) ---
Route::get('/', function () {
    return view('welcome');
});

// Rute Login & Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// --- RUTE ADMIN (Terkunci oleh Middleware 'auth') ---
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    
    // CRUD Merek
    Route::resource('brands', BrandController::class);
    
    // CRUD Mobil
    Route::resource('cars', CarController::class);

    // Manajemen Pesan Masuk
    Route::resource('messages', MessageController::class)->only(['index', 'show', 'destroy']);
    
});
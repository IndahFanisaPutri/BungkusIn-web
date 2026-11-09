<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/* ---------------------------- Route Publik ---------------------------- */
// Sementara berupa view placeholder; ganti ke controller pada minggu berikutnya.
Route::view('/', 'welcome')->name('home');
Route::view('/katalog', 'katalog')->name('katalog');
Route::view('/kategori', 'kategori')->name('kategori');

/* ----------------------------- Route Guest ---------------------------- */
// Hanya bisa diakses jika BELUM login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); // nama 'login' dipakai Laravel untuk redirect guest
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

/* ------------------------------ Route Auth ---------------------------- */
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/* ------------------------- Route Role: Merchant ----------------------- */
Route::middleware(['auth', 'role:merchant'])->prefix('merchant')->name('merchant.')->group(function () {
    Route::view('/dashboard', 'merchant.dashboard')->name('dashboard');
});

/* -------------------------- Route Role: Admin ------------------------- */
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
});

<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureRole;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');
Route::redirect('/home', '/dashboard'); // tujuan bawaan Laravel setelah login

// ---- Tamu (belum login) ----
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

// ---- Sudah login ----
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');

    // Detail laporan: pelapor (miliknya sendiri) dan admin (semua) - dicek di controller
    Route::get('/laporan/{report}', [LaporanController::class, 'show'])->whereNumber('report')->name('laporan.show');

    // ---- Pelapor (Mahasiswa & Dosen/Tendik) ----
    Route::middleware(EnsureRole::class . ':pelapor')->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/buat', [LaporanController::class, 'create'])->name('laporan.create');
        Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
    });

    // ---- Admin (Sarpras) ----
    Route::middleware(EnsureRole::class . ':admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan.index');
        Route::put('/laporan/{report}/status', [AdminController::class, 'updateStatus'])->whereNumber('report')->name('laporan.status');
        Route::get('/statistik', [AdminController::class, 'statistik'])->name('statistik');

        // CRUD data master
        Route::resource('kategori', CategoryController::class)->except('show')->parameters(['kategori' => 'category']);
        Route::resource('lokasi', LocationController::class)->except('show')->parameters(['lokasi' => 'location']);
        Route::resource('pengguna', UserController::class)->except('show')->parameters(['pengguna' => 'user']);
    });
});
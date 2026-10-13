<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ---- Halaman Pelapor (Mahasiswa & Dosen/Tendik) ----
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/buat', [LaporanController::class, 'create'])->name('laporan.create');
Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');

// ---- Halaman Admin (sementara placeholder, diisi di pertemuan berikutnya) ----
Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/laporan', 'placeholder', ['judul' => 'Laporan Masuk'])->name('laporan.index');
    Route::view('/kategori', 'placeholder', ['judul' => 'Kategori'])->name('kategori.index');
    Route::view('/lokasi', 'placeholder', ['judul' => 'Lokasi'])->name('lokasi.index');
    Route::view('/pengguna', 'placeholder', ['judul' => 'Pengguna'])->name('pengguna.index');
    Route::view('/statistik', 'placeholder', ['judul' => 'Statistik & Cetak'])->name('statistik');
});

Route::view('/profil', 'placeholder', ['judul' => 'Edit Profil'])->name('profil.edit');

// ---- SEMENTARA: ganti role untuk demo (hapus saat autentikasi sudah ada, minggu 7) ----
Route::get('/demo/role/{role}', function (string $role) {
    session(['role' => $role]);
    return redirect()->route('dashboard');
})->whereIn('role', ['pelapor', 'admin'])->name('demo.role');

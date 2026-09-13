<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;

// 1. Rute Akar (Landing Page Utama Publik)
Route::get('/', [AppController::class, 'landing'])->name('landing');

// 2. Rute Tamu / Belum Login
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AppController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AppController::class, 'login'])->name('login.perform');
});

// 3. Rute Autentikasi / Sudah Login
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AppController::class, 'logout'])->name('logout');

    // Dilihat oleh SEMUA Role (Admin, Pimpinan, Pegawai)
    Route::get('/dashboard', [AppController::class, 'dashboard'])->name('dashboard');
    Route::get('/kalender', [AppController::class, 'kalender'])->name('kalender');

    // Dilihat oleh Pimpinan dan Admin
    Route::middleware(['role:pimpinan,admin'])->group(function () {
        Route::get('/riwayat-kerja', [AppController::class, 'riwayatKerja'])->name('riwayat-kerja');
        Route::get('/jenis-kegiatan', [AppController::class, 'jenisKegiatan'])->name('jenis-kegiatan');
        Route::get('/titik-lokasi', [AppController::class, 'titikLokasi'])->name('titik-lokasi');
        Route::get('/instansi', [AppController::class, 'instansi'])->name('instansi');
        Route::get('/riwayat-kegiatan', [AppController::class, 'riwayatKegiatan'])->name('riwayat-kegiatan');
    });

    // Khusus Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/kegiatan', [AppController::class, 'kegiatan'])->name('kegiatan');
        Route::get('/master-user', [AppController::class, 'masterUser'])->name('master-user');
        Route::get('/master-kegiatan', [AppController::class, 'masterKegiatan'])->name('master-kegiatan');
        Route::get('/master-lokasi', [AppController::class, 'masterLokasi'])->name('master-lokasi');
    });
});
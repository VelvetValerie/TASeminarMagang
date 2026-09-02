<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppController;

// Rute Tamu (Guest) - Formulir Login Berada di Landing Page URL ( / )
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/', [AuthController::class, 'login'])->name('login.perform');
    
    // Opsional: jika ada yang mengakses /login, langsung arahkan ke /
    Route::get('/login', fn() => redirect()->route('login'));
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rute Internal (Wajib Login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AppController::class, 'dashboard'])->name('dashboard');
    Route::get('/kegiatan', [AppController::class, 'kegiatan'])->name('kegiatan.index');
    Route::post('/kegiatan', [AppController::class, 'storeKegiatan'])->name('kegiatan.store');
    Route::delete('/kegiatan/{id}', [AppController::class, 'destroyKegiatan'])->name('kegiatan.destroy');
    Route::get('/kalender', [AppController::class, 'kalender'])->name('kalender');
    Route::get('/titik-lokasi', [AppController::class, 'titikLokasi'])->name('titik-lokasi');
    Route::get('/instansi', [AppController::class, 'instansi'])->name('instansi');
    Route::get('/jenis-kegiatan', [AppController::class, 'jenisKegiatan'])->name('jenis-kegiatan');
    Route::get('/riwayat-kerja', [AppController::class, 'riwayatKerja'])->name('riwayat-kerja');
    Route::get('/riwayat-kegiatan', [AppController::class, 'riwayatKegiatan'])->name('riwayat-kegiatan');
});
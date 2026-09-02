<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppController;

// 1. Root URL ( / ) mengarah ke Landing Page (Publik)
Route::get('/', function () {
    return view('landing');
})->name('landing');

// 2. Rute Autentikasi untuk Tamu (Guest) berada di /login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
});

// 3. Logout (Kembali ke Landing Page /)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// 4. Halaman Internal Sistem (Wajib Login)
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
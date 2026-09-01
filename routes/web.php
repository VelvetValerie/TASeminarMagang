<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;

Route::get('/', function () {
    return view('landing');
});

// Dashboard
Route::get('/dashboard', [AppController::class, 'dashboard'])->name('dashboard');

// Kegiatan (Wajib lewat Controller agar $kegiatan, $jenisList, dll terkirim)
Route::get('/kegiatan', [AppController::class, 'kegiatan'])->name('kegiatan.index');
Route::post('/kegiatan', [AppController::class, 'storeKegiatan'])->name('kegiatan.store');
Route::delete('/kegiatan/{id}', [AppController::class, 'destroyKegiatan'])->name('kegiatan.destroy');

// Submenu Lainnya
Route::get('/kalender', [AppController::class, 'kalender'])->name('kalender');
Route::get('/titik-lokasi', [AppController::class, 'titikLokasi'])->name('titik-lokasi');
Route::get('/instansi', [AppController::class, 'instansi'])->name('instansi');
Route::get('/jenis-kegiatan', [AppController::class, 'jenisKegiatan'])->name('jenis-kegiatan');
Route::get('/riwayat-kerja', [AppController::class, 'riwayatKerja'])->name('riwayat-kerja');
Route::get('/riwayat-kegiatan', [AppController::class, 'riwayatKegiatan'])->name('riwayat-kegiatan');
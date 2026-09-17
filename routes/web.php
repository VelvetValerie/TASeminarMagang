<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Models\Kegiatan;

// 1. Rute Akar (Landing Page Utama Publik)
Route::get('/', function () {return view('landing'); })->name('landing');
Route::get('/', function () {
    // Ambil data kegiatan beserta relasinya (jenis, lokasi, koordinator)
    $kegiatan = Kegiatan::with(['jenis', 'lokasi', 'koordinator'])->get();

    return view('landing', compact('kegiatan'));
})->name('landing');

// 2. Rute Tamu / Belum Login (Guest)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AppController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AppController::class, 'login'])->name('login.perform');

    // Fitur Tambahan: Lupa Password & OTP (Auto-fill)
    Route::get('/forgot-password', [AppController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AppController::class, 'sendResetOtp'])->name('password.email');
    Route::get('/verify-otp', [AppController::class, 'showVerifyOtpForm'])->name('password.verify.form');
    Route::post('/reset-password', [AppController::class, 'resetPassword'])->name('password.update');
});

// 3. Rute Autentikasi / Sudah Login (Auth)
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
        Route::post('/master-user', [AppController::class, 'storeUser'])->name('master-user.store');
        Route::put('/master-user/{id}', [AppController::class, 'updateUser'])->name('master-user.update');
        Route::delete('/master-user/{id}', [AppController::class, 'destroyUser'])->name('master-user.destroy');
    });
});
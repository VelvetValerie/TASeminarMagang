<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LaporanKegiatanController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Models\Kegiatan;
use App\Http\Controllers\Api\Public\KalenderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. RUTE PUBLIK (TIDAK PERLU LOGIN)
// ==========================================
Route::get('/', function () {
    $kegiatan = Kegiatan::with(['jenis', 'lokasi', 'koordinator'])->get();
    return view('landing', compact('kegiatan'));
})->name('landing');

Route::get('/kalender-kegiatan', [KalenderController::class, 'getKegiatan']);

Route::get('/berita', function () {
    return view('news');
});

Route::get('/berita/detail', function () {
    return view('news_detail');
});

Route::get('/informasi', function () {
    return view('information');
});

Route::get('/informasi/timeline', function () {
    return view('timeline_detail');
});


// ==========================================
// 2. RUTE TAMU / GUEST (BELUM LOGIN)
// ==========================================
Route::middleware(['guest'])->group(function () {
    // Halaman & Proses Login (Di-throttle maks 5x per menit)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.perform');

    // Lupa Password & Reset OTP (Di-throttle untuk keamanan)
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    
    // Maksimal 3 kali minta OTP dalam 1 menit
    Route::post('/forgot-password', [AuthController::class, 'sendResetOtp'])
        ->middleware('throttle:3,1')
        ->name('password.email');

    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtpForm'])->name('password.verify.form');
    
    // Maksimal 5 kali coba verifikasi OTP dalam 1 menit
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->middleware('throttle:5,1')
        ->name('password.update');
});


// ==========================================
// 3. RUTE AUTENTIKASI (SUDAH LOGIN)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dilihat oleh SEMUA Role (Admin, Pimpinan, Pegawai)
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/kalender', [DashboardController::class, 'kalender'])->name('kalender');

    // PERENCANAAN KEGIATAN
    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan');
    Route::post('/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');
    Route::put('/kegiatan/{id}', [KegiatanController::class, 'update'])->name('kegiatan.update');
    Route::delete('/kegiatan/{id}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');

    // LAPORAN KEGIATAN
    Route::get('/laporan-kegiatan', [LaporanKegiatanController::class, 'index'])->name('laporan-kegiatan');
    Route::post('/laporan-kegiatan', [LaporanKegiatanController::class, 'store'])->name('laporan-kegiatan.store');
    Route::put('/laporan-kegiatan/{id}', [LaporanKegiatanController::class, 'update'])->name('laporan-kegiatan.update');
    Route::delete('/laporan-kegiatan/{id}', [LaporanKegiatanController::class, 'destroy'])->name('laporan-kegiatan.destroy');
    Route::get('/laporan-kegiatan/{id}/cetak', [LaporanKegiatanController::class, 'cetakPdfLaporan']);
    Route::get('/laporan-kegiatan/export-csv', [LaporanKegiatanController::class, 'exportCsv']);

    // KHUSUS ROLE ADMIN (Master Data Teknis & Pengelolaan User)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/riwayat-kerja', [MasterDataController::class, 'riwayatKerja'])->name('riwayat-kerja');
        Route::get('/jenis-kegiatan', [MasterDataController::class, 'jenisKegiatan'])->name('jenis-kegiatan');
        Route::get('/titik-lokasi', [MasterDataController::class, 'titikLokasi'])->name('titik-lokasi');
        Route::get('/instansi', [MasterDataController::class, 'instansi'])->name('instansi');
        Route::get('/riwayat-kegiatan', [KegiatanController::class, 'riwayatKegiatan'])->name('riwayat-kegiatan');

        // Manajemen Master User
        Route::get('/master-user', [UserController::class, 'index'])->name('master-user');
        Route::post('/master-user', [UserController::class, 'store'])->name('master-user.store');
        Route::put('/master-user/{id}', [UserController::class, 'update'])->name('master-user.update');
        Route::delete('/master-user/{id}', [UserController::class, 'destroy'])->name('master-user.destroy');
    });

});
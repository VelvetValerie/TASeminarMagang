<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LaporanKegiatanController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\Public\BeritaController;
use App\Http\Controllers\AdminBeritaController;
use App\Models\Kegiatan;

// 1. Rute Publik
Route::get('/', function () {
    $kegiatan = Kegiatan::with(['jenis', 'lokasi', 'koordinator'])->get();
    return view('landing', compact('kegiatan'));
})->name('landing');

Route::get('/kalender-kegiatan', [KalenderController::class, 'getKegiatan']);

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/detail/{slug}', [BeritaController::class, 'show'])->name('berita.show');

Route::get('/informasi', function () {
    return view('information');
});

Route::get('/informasi/timeline', function () {
    return view('timeline_detail');
});

// 2. Rute Tamu / Belum Login (Guest)
// 2. Guest Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetOtp'])->name('password.email');
    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtpForm'])->name('password.verify.form');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// 3. Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard & Kalender
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/kalender', [DashboardController::class, 'kalender'])->name('kalender');

    // Perencanaan Kegiatan
    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan');
    Route::post('/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');
    Route::put('/kegiatan/{id}', [KegiatanController::class, 'update'])->name('kegiatan.update');
    Route::delete('/kegiatan/{id}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');

    // Laporan Kegiatan
    Route::get('/laporan-kegiatan', [LaporanKegiatanController::class, 'index'])->name('laporan-kegiatan');
    Route::post('/laporan-kegiatan', [LaporanKegiatanController::class, 'store'])->name('laporan-kegiatan.store');
    Route::put('/laporan-kegiatan/{id}', [LaporanKegiatanController::class, 'update'])->name('laporan-kegiatan.update');
    Route::delete('/laporan-kegiatan/{id}', [LaporanKegiatanController::class, 'destroy'])->name('laporan-kegiatan.destroy');
    Route::get('/laporan-kegiatan/{id}/cetak', [LaporanKegiatanController::class, 'cetakPdfLaporan']);
    Route::get('/laporan-kegiatan/export-csv', [LaporanKegiatanController::class, 'exportCsv']);

    // Khusus Admin (Master Data)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/master-user', [AppController::class, 'masterUser'])->name('master-user');
        Route::post('/master-user', [AppController::class, 'storeUser'])->name('master-user.store');
        Route::put('/master-user/{id}', [AppController::class, 'updateUser'])->name('master-user.update');
        Route::delete('/master-user/{id}', [AppController::class, 'destroyUser'])->name('master-user.destroy');

        Route::get('/admin/berita', [AdminBeritaController::class, 'index'])->name('admin.berita.index');
        Route::get('/admin/berita/create', [AdminBeritaController::class, 'create'])->name('admin.berita.create');
        Route::post('/admin/berita', [AdminBeritaController::class, 'store'])->name('admin.berita.store');
        Route::get('/admin/berita/{slug}/edit', [AdminBeritaController::class, 'edit'])->name('admin.berita.edit');
        Route::put('/admin/berita/{slug}', [AdminBeritaController::class, 'update'])->name('admin.berita.update');
        Route::delete('/admin/berita/{id}', [AdminBeritaController::class, 'destroy'])->name('admin.berita.destroy');
        Route::get('/riwayat-kerja', [MasterDataController::class, 'riwayatKerja'])->name('riwayat-kerja');
        Route::get('/jenis-kegiatan', [MasterDataController::class, 'jenisKegiatan'])->name('jenis-kegiatan');
        Route::get('/titik-lokasi', [MasterDataController::class, 'titikLokasi'])->name('titik-lokasi');
        Route::get('/instansi', [MasterDataController::class, 'instansi'])->name('instansi');
        Route::get('/riwayat-kegiatan', [KegiatanController::class, 'riwayatKegiatan'])->name('riwayat-kegiatan');

        Route::get('/master-user', [UserController::class, 'index'])->name('master-user');
        Route::post('/master-user', [UserController::class, 'store'])->name('master-user.store');
        Route::put('/master-user/{id}', [UserController::class, 'update'])->name('master-user.update');
        Route::delete('/master-user/{id}', [UserController::class, 'destroy'])->name('master-user.destroy');
    });
});
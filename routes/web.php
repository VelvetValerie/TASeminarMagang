<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LaporanKegiatanController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminBeritaController;
use App\Http\Controllers\AdminInformasiController;
use App\Models\Kegiatan;
use App\Http\Controllers\Api\Public\KalenderController;
use App\Http\Controllers\Api\Public\BeritaController;
use App\Http\Controllers\Api\Public\InformasiController;

// Rute Publik Landing Page
Route::get('/', function () {
    $kegiatan = Kegiatan::with(['jenis', 'lokasi', 'koordinator'])->get();
    return view('landing', compact('kegiatan'));
})->name('landing');

Route::get('/kalender-kegiatan', [KalenderController::class, 'getKegiatan']);

// Rute Publik Berita
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

// Rute Publik Informasi Resmi
Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi.index');
Route::get('/informasi/timeline', function () {
    return view('timeline_detail');
})->name('informasi.timeline');
Route::get('/informasi/{slug}', [InformasiController::class, 'show'])->name('informasi.show');


// Auth Routes (Guest)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.perform');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetOtp'])->middleware('throttle:3,1')->name('password.email');
    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtpForm'])->name('password.verify.form');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('throttle:5,1')->name('password.update');
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 1. DASHBOARD & KALENDER (Bisa diakses oleh SEMUA ROLE)
    Route::middleware(['role:admin,pimpinan,pegawai_koordinasi,pegawai_humas'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/kalender', [DashboardController::class, 'kalender'])->name('kalender');
    });

    // 2. KEGIATAN & LAPORAN KEGIATAN (Hanya Admin, Pimpinan, dan Pegawai Koordinator)
    Route::middleware(['role:admin,pimpinan,pegawai_koordinasi'])->group(function () {
        Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan');
        Route::post('/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');
        Route::put('/kegiatan/{id}', [KegiatanController::class, 'update'])->name('kegiatan.update');
        Route::delete('/kegiatan/{id}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');

        Route::get('/laporan-kegiatan', [LaporanKegiatanController::class, 'index'])->name('laporan-kegiatan');
        Route::post('/laporan-kegiatan', [LaporanKegiatanController::class, 'store'])->name('laporan-kegiatan.store');
        Route::put('/laporan-kegiatan/{id}', [LaporanKegiatanController::class, 'update'])->name('laporan-kegiatan.update');
        Route::delete('/laporan-kegiatan/{id}', [LaporanKegiatanController::class, 'destroy'])->name('laporan-kegiatan.destroy');
        Route::get('/laporan-kegiatan/{id}/cetak', [LaporanKegiatanController::class, 'cetakPdfLaporan']);
        Route::get('/laporan-kegiatan/export-csv', [LaporanKegiatanController::class, 'exportCsv']);
    });

    // 3. PUSAT INFORMASI & BERITA ADMIN (Hanya Admin dan Pegawai Humas)
    Route::middleware(['role:admin,pegawai_humas'])->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/berita', [AdminBeritaController::class, 'index'])->name('berita.index');
            Route::get('/berita/create', [AdminBeritaController::class, 'create'])->name('berita.create');
            Route::post('/berita', [AdminBeritaController::class, 'store'])->name('berita.store');
            Route::get('/berita/{slug}/edit', [AdminBeritaController::class, 'edit'])->name('berita.edit');
            Route::put('/berita/{slug}', [AdminBeritaController::class, 'update'])->name('berita.update');
            Route::delete('/berita/{id}', [AdminBeritaController::class, 'destroy'])->name('berita.destroy');

            Route::get('/informasi', [AdminInformasiController::class, 'index'])->name('informasi.index');
            Route::get('/informasi/create', [AdminInformasiController::class, 'create'])->name('informasi.create');
            Route::post('/informasi', [AdminInformasiController::class, 'store'])->name('informasi.store');
            Route::get('/informasi/{slug}/edit', [AdminInformasiController::class, 'edit'])->name('informasi.edit');
            Route::put('/informasi/{slug}', [AdminInformasiController::class, 'update'])->name('informasi.update');
            Route::delete('/informasi/{id}', [AdminInformasiController::class, 'destroy'])->name('informasi.destroy');
        });
    });

    // 4. KHUSUS ROLE ADMIN
    Route::middleware(['role:admin'])->group(function () {
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
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

    //3. RUTE KHUSUS YANG BISA DIAKSES OLEH ADMIN DAN PEGAWAI HUMAS
    Route::middleware(['auth', 'role:admin,pegawai_humas'])->prefix('admin')->name('admin.')->group(function () {
        
        // CRUD Berita
        Route::get('/berita', [AdminBeritaController::class, 'index'])->name('berita.index');
        Route::get('/berita/create', [AdminBeritaController::class, 'create'])->name('berita.create');
        Route::post('/berita', [AdminBeritaController::class, 'store'])->name('berita.store');
        Route::get('/berita/{slug}/edit', [AdminBeritaController::class, 'edit'])->name('berita.edit');
        Route::put('/berita/{slug}', [AdminBeritaController::class, 'update'])->name('berita.update');
        Route::post('/berita/{id}/delete-image', [AdminBeritaController::class, 'deleteImage'])->name('berita.delete-image');
        Route::delete('/berita/{id}', [AdminBeritaController::class, 'destroy'])->name('berita.destroy');

        // CRUD Informasi Resmi
        Route::get('/informasi', [AdminInformasiController::class, 'index'])->name('informasi.index');
        Route::get('/informasi/create', [AdminInformasiController::class, 'create'])->name('informasi.create');
        Route::post('/informasi', [AdminInformasiController::class, 'store'])->name('informasi.store');
        Route::get('/informasi/{slug}/edit', [AdminInformasiController::class, 'edit'])->name('informasi.edit');
        Route::put('/informasi/{slug}', [AdminInformasiController::class, 'update'])->name('informasi.update');
        Route::post('/informasi/{id}/delete-image', [AdminInformasiController::class, 'deleteImage'])->name('informasi.delete-image');
        Route::delete('/informasi/{id}', [AdminInformasiController::class, 'destroy'])->name('informasi.destroy');
    });

    //4. RUTE KHUSUS DRAFT BERITA (Hanya Admin)
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/berita/draft', [AdminBeritaController::class, 'draftIndex'])->name('berita.draft');
    });
});
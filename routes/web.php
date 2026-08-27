<?php

use Illuminate\Support\Facades\Route;

// Rute Publik Landing Page
Route::get('/', function () {
    return view('landing');
});

// Rute Aplikasi Internal Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/kalender', function () {
    return view('kalender');
});

Route::get('/kegiatan', function () {
    return view('kegiatan');
});

Route::get('/riwayat-kerja', function () {
    return view('riwayat-kerja');
});

Route::get('/riwayat-kegiatan', function () {
    return view('riwayat-kegiatan');
});

Route::get('/titik-lokasi', function () {
    return view('titik-lokasi');
});

Route::get('/instansi', function () {
    return view('instansi');
});

Route::get('/jenis-kegiatan', function () {
    return view('jenis-kegiatan');
});
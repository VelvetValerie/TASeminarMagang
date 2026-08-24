<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/kalender', function () {
    return view('kalender');
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
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Mitra\MitraDashboardController;
use App\Http\Controllers\Pelanggan\PelangganController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\Pages\HomeController;

// ========================
// Landing Page Umum
// ========================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ========================
// Register (Kustom Role)
// ========================
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// ========================
// Auth Default dari Breeze
// ========================
require __DIR__ . '/auth.php';

// ========================
// Superadmin Routes
// ========================
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'index'])->name('superadmin.dashboard');
});

// ========================
// Mitra Routes
// ========================
Route::middleware(['auth', 'role:mitra'])->group(function () {
    Route::get('/mitra/dashboard', [MitraDashboardController::class, 'index'])->name('mitra.dashboard');
});

// ========================
// Pelanggan Routes
// ========================
Route::middleware(['auth', 'role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/mitra', [PelangganController::class, 'indexMitra'])->name('mitra');
    Route::get('/layanan/{slug}', [PelangganController::class, 'layananMitra'])->name('layanan.show');
    Route::post('/pesan/{slug}', [PelangganController::class, 'pesanMitra'])->name('pesan');
    Route::get('/toko/{id}', [PelangganController::class, 'showToko'])->name('toko.show');
    Route::get('/tracking/{id}', [PelangganController::class, 'trackingMitra'])->name('tracking');
    Route::get('/konfirmasi/{id}', [PelangganController::class, 'konfirmasiMitra'])->name('konfirmasi');
    Route::post('/konfirmasi/{id}', [PelangganController::class, 'updateKonfirmasiMitra'])->name('konfirmasi.update');

    // ✅ Route profil diperbaiki
    Route::get('/profil', [PelangganController::class, 'profil'])->name('profil');
    Route::patch('/profil', [PelangganController::class, 'updateProfil'])->name('profil.update');

    Route::get('/riwayat', [PelangganController::class, 'riwayatMitra'])->name('riwayat');
    Route::get('/layanan-statis/{nama}', [PelangganController::class, 'showLayananStatis'])->name('layanan.statis');
    Route::post('/layanan-statis/{toko}', [PelangganController::class, 'storeLayananStatis'])->name('layanan.statis.store');

    Route::get('/data-diri', [PelangganController::class, 'formDataDiri'])->name('data-diri');
    Route::post('/data-diri', [PelangganController::class, 'simpanDataDiri'])->name('simpan-data-diri');
});

// ========================
// Default Profile Routes dari Breeze (bisa dihapus jika sudah pakai PelangganController)
// ========================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========================
// Halaman Tambahan
// ========================
Route::view('/jadimitra', 'pages.jadimitra')->name('jadimitra');
Route::get('/pelacakan', [HomeController::class, 'track'])->name('pelacakan');

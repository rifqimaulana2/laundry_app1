<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Superadmin
use App\Http\Controllers\Superadmin\DashboardController;
use App\Http\Controllers\Superadmin\MitraController;
use App\Http\Controllers\Superadmin\PelangganController;
use App\Http\Controllers\Superadmin\LayananController;
use App\Http\Controllers\Superadmin\TransaksiController;
use App\Http\Controllers\Superadmin\NotifikasiController;
use App\Http\Controllers\Superadmin\PaketController;
use App\Http\Controllers\Superadmin\JamOperasionalController as SuperadminJamController;
use App\Http\Controllers\Superadmin\TagihanPembayaranController;

// Mitra
use App\Http\Controllers\Mitra\DashboardMitraController;
use App\Http\Controllers\Mitra\PesananMitraController;
use App\Http\Controllers\Mitra\LayananMitraController;
use App\Http\Controllers\Mitra\JamOperasionalController as MitraJamController;
use App\Http\Controllers\Mitra\LanggananMitraController;
use App\Http\Controllers\Mitra\NotifikasiMitraController;
use App\Http\Controllers\Mitra\ProfilMitraController;

// ========================
// Halaman Umum & Auth
// ========================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pelacakan', [HomeController::class, 'track'])->name('pelacakan');
Route::view('/jadimitra', 'pages.jadimitra')->name('jadimitra');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

require __DIR__ . '/auth.php';

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// ========================
// Superadmin Routes
// ========================
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Mitra
    Route::get('/mitra', [MitraController::class, 'index'])->name('mitra.index');
    Route::get('/mitra/pending', [MitraController::class, 'pending'])->name('mitra.pending');
    Route::get('/mitra/{id}', [MitraController::class, 'show'])->name('mitra.show');
    Route::get('/mitra/{id}/edit', [MitraController::class, 'edit'])->name('mitra.edit');
    Route::put('/mitra/{id}', [MitraController::class, 'update'])->name('mitra.update');
    Route::post('/mitra/{id}/approve', [MitraController::class, 'approve'])->name('mitra.approve');
    Route::post('/mitra/{id}/approve-mitra', [MitraController::class, 'approveMitra'])->name('mitra.approveMitra');
    Route::post('/mitra/{id}/deactivate', [MitraController::class, 'deactivate'])->name('mitra.deactivate');
    Route::post('/mitra/{id}/extend', [MitraController::class, 'extend'])->name('mitra.extend');
    Route::delete('/mitra/{id}', [MitraController::class, 'destroy'])->name('mitra.destroy');
    Route::delete('/mitra/{id}/reject', [MitraController::class, 'reject'])->name('mitra.reject');

    // Pelanggan
    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/pelanggan/{id}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
    Route::put('/pelanggan/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
    Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');

    // Layanan
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
    Route::post('/layanan', [LayananController::class, 'store'])->name('layanan.store');
    Route::put('/layanan/{id}', [LayananController::class, 'update'])->name('layanan.update');
    Route::delete('/layanan/{id}/{type}', [LayananController::class, 'destroy'])->name('layanan.destroy');

    // Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');

    // Notifikasi
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.markAsRead');
    Route::delete('/notifikasi/{id}', [NotifikasiController::class, 'destroy'])->name('notifikasi.destroy');

    // Paket
    Route::get('/paket', [PaketController::class, 'index'])->name('paket.index');
    Route::post('/paket', [PaketController::class, 'store'])->name('paket.store');
    Route::delete('/paket/{id}', [PaketController::class, 'destroy'])->name('paket.destroy');

    // Jam Operasional
    Route::prefix('jam')->name('jam.')->group(function () {
        Route::get('/', [SuperadminJamController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [SuperadminJamController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SuperadminJamController::class, 'update'])->name('update');
    });

    // Tagihan Pembayaran
    Route::get('/tagihan', [TagihanPembayaranController::class, 'index'])->name('tagihan.index');
});

// ========================
// Mitra Routes
// ========================
Route::middleware(['auth', 'role:mitra'])->prefix('mitra')->name('mitra.')->group(function () {
    Route::get('/dashboard', [DashboardMitraController::class, 'index'])->name('dashboard');

    // Pesanan
    Route::get('/pesanan', [PesananMitraController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [PesananMitraController::class, 'show'])->name('pesanan.show');

    // Layanan
    Route::get('/layanan', [LayananMitraController::class, 'index'])->name('layanan.index');
    Route::get('/layanan/create', [LayananMitraController::class, 'create'])->name('layanan.create');
    Route::post('/layanan', [LayananMitraController::class, 'store'])->name('layanan.store');

    // Jam Operasional
    Route::get('/jam-operasional', [MitraJamController::class, 'index'])->name('jam-operasional.index');

    // Langganan
    Route::get('/langganan', [LanggananMitraController::class, 'index'])->name('langganan.index');

    // Notifikasi
    Route::get('/notifikasi', [NotifikasiMitraController::class, 'index'])->name('notifikasi.index');

    // Profil
    Route::get('/profil', [ProfilMitraController::class, 'index'])->name('profil.index');
    Route::get('/profil/edit', [ProfilMitraController::class, 'edit'])->name('profil.edit');
    Route::put('/profil/update', [ProfilMitraController::class, 'update'])->name('profil.update');
});

// ========================
// Pelanggan Routes
// ========================
Route::middleware(['auth', 'role:pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'pelanggan'])->name('dashboard');
    Route::get('/lengkapi-profil', [PelangganController::class, 'create'])->name('lengkapi-profil');
    Route::post('/simpan-profil', [PelangganController::class, 'simpanProfil'])->name('simpan-profil');
    Route::get('/data-diri', [PelangganController::class, 'create'])->name('data-diri');
});

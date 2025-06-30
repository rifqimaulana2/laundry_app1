<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Superadmin Controllers
use App\Http\Controllers\Superadmin\DashboardController;
use App\Http\Controllers\Superadmin\MitraController;
use App\Http\Controllers\Superadmin\PelangganController;
use App\Http\Controllers\Superadmin\PaketController;
use App\Http\Controllers\Superadmin\LayananController;
use App\Http\Controllers\Superadmin\TransaksiController;
use App\Http\Controllers\Superadmin\NotifikasiController;
use App\Http\Controllers\Superadmin\MitraApprovalController;

// Mitra Controllers
use App\Http\Controllers\Mitra\DashboardMitraController;
use App\Http\Controllers\Mitra\PesananMitraController;
use App\Http\Controllers\Mitra\LayananMitraController;
use App\Http\Controllers\Mitra\JamOperasionalController;
use App\Http\Controllers\Mitra\LanggananMitraController;
use App\Http\Controllers\Mitra\NotifikasiMitraController;
use App\Http\Controllers\Mitra\ProfilMitraController;

// ========================
// Landing Page Umum
// ========================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pelacakan', [HomeController::class, 'track'])->name('pelacakan');
Route::view('/jadimitra', 'pages.jadimitra')->name('jadimitra');

// ========================
// Custom Register
// ========================
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// ========================
// Auth Laravel Breeze
// ========================
require __DIR__ . '/auth.php';

// ========================
// Superadmin Routes
// ========================
Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

    Route::prefix('mitra')->name('mitra.')->group(function () {
    });
        Route::get('/pending', [MitraApprovalController::class, 'index'])->name('pending');
        Route::patch('/{id}/approve', [MitraApprovalController::class, 'approve'])->name('approve');
        Route::delete('/{id}', [MitraApprovalController::class, 'reject'])->name('reject');

        // lainnya: index, show, edit, update
    });
Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

    // 📊 Dashboard superadmin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ✅ Approval Mitra
    Route::prefix('mitra')->name('mitra.')->group(function () {
        Route::get('/pending', [MitraApprovalController::class, 'index'])->name('pending');
        Route::patch('/{id}/approve', [MitraApprovalController::class, 'approve'])->name('approve');
        Route::delete('/{id}', [MitraApprovalController::class, 'reject'])->name('reject');
    });

    // 👥 Manajemen Mitra (yang sudah disetujui)
    Route::get('/mitra', [MitraController::class, 'index'])->name('mitra.index');
    Route::get('/mitra/{id}', [MitraController::class, 'show'])->name('mitra.show');
    Route::get('/mitra/{id}/edit', [MitraController::class, 'edit'])->name('mitra.edit');
    Route::patch('/mitra/{id}', [MitraController::class, 'update'])->name('mitra.update');

    // 👤 Manajemen Pelanggan
    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');

    // 🧺 Paket Langganan
    Route::get('/paket', [PaketController::class, 'index'])->name('paket.index');

    // 🧼 Layanan
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');

    // 💳 Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');

    // 🔔 Notifikasi
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
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
    Route::get('/layanan/{id}/edit', [LayananMitraController::class, 'edit'])->name('layanan.edit');
    Route::put('/layanan/{id}', [LayananMitraController::class, 'update'])->name('layanan.update');

    // Jam Operasional
    Route::get('/jam-operasional', [JamOperasionalController::class, 'index'])->name('jam-operasional.index');

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

    // Tambahkan route lainnya seperti pesanan, riwayat, dll nanti
});

// ========================
// Logout
// ========================
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// ========================
// Testing Session
// ========================
Route::get('/session-test', function () {
    session(['tes' => 'berhasil']);
    return session('tes');
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Superadmin
use App\Http\Controllers\Superadmin\DashboardController as SuperadminDashboardController;
use App\Http\Controllers\Superadmin\UserController;
use App\Http\Controllers\Superadmin\MitraController;
use App\Http\Controllers\Superadmin\LayananMasterController;
use App\Http\Controllers\Superadmin\MitraApprovalController;
use App\Http\Controllers\Superadmin\StatusMasterController;

// Mitra
use App\Http\Controllers\Mitra\DashboardController as MitraDashboardController;
use App\Http\Controllers\Mitra\ProfilController as MitraProfilController;
use App\Http\Controllers\Mitra\JamOperasionalController;
use App\Http\Controllers\Mitra\LayananKiloanController as MitraLayananKiloanController;
use App\Http\Controllers\Mitra\LayananSatuanController as MitraLayananSatuanController;
use App\Http\Controllers\Mitra\EmployeeController as MitraEmployeeController;
use App\Http\Controllers\Mitra\WalkinCustomerController as MitraWalkinCustomerController;
use App\Http\Controllers\Mitra\PesananController as MitraPesananController;
use App\Http\Controllers\Mitra\TagihanController as MitraTagihanController;
use App\Http\Controllers\Mitra\RiwayatTransaksiController;
use App\Http\Controllers\Mitra\TrackingStatusController;

// Employee
use App\Http\Controllers\Employee\DashboardController;
use App\Http\Controllers\Employee\PesananController;
use App\Http\Controllers\Employee\TagihanController;
use App\Http\Controllers\Employee\WalkinCustomerController;

// Pelanggan
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;
use App\Http\Controllers\Pelanggan\MitraController as PelangganMitraController;
use App\Http\Controllers\Pelanggan\PesananController as PelangganPesananController;
use App\Http\Controllers\Pelanggan\TagihanController as PelangganTagihanController;
use App\Http\Controllers\Pelanggan\ProfilController as PelangganProfilController;

// Halaman Umum
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/tentangkami', 'pages.tentangkami')->name('tentangkami');
Route::view('/carakerja', 'pages.carakerja')->name('carakerja');
Route::view('/daftarlayanan', 'pages.daftarlayanan')->name('daftarlayanan');
Route::view('/jadimitra', 'pages.jadimitra')->name('jadimitra');
Route::view('/pelacakan', 'pages.pelacakan')->name('pelacakan');

// Auth
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
require __DIR__ . '/auth.php';
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Midtrans Payment Callback
Route::post('/tagihan/midtrans/notify', [PelangganTagihanController::class, 'midtransCallback'])->name('tagihan.callback');

// SUPERADMIN
Route::prefix('superadmin')->middleware(['auth', 'role:superadmin'])->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperadminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/mitras/approval', [MitraApprovalController::class, 'index'])->name('mitras.approval.index');
    Route::post('/mitras/approve/{id}', [MitraApprovalController::class, 'approve'])->name('mitras.approve');
    Route::post('/mitras/reject/{id}', [MitraApprovalController::class, 'reject'])->name('mitras.reject');

    Route::resource('mitras', MitraController::class);
    Route::resource('users', UserController::class);

    Route::prefix('layanan-master')->group(function () {
        Route::get('/', [LayananMasterController::class, 'index'])->name('layanan-master.index');

        // Status Master
        Route::resource('status-master', StatusMasterController::class)->except(['show']);

        // Jenis Layanan
        Route::get('jenis/create', [LayananMasterController::class, 'createJenis'])->name('layanan-master.jenis.create');
        Route::post('jenis', [LayananMasterController::class, 'storeJenis'])->name('layanan-master.jenis.store');
        Route::get('jenis/{jenisLayanan}/edit', [LayananMasterController::class, 'editJenis'])->name('layanan-master.jenis.edit');
        Route::put('jenis/{jenisLayanan}', [LayananMasterController::class, 'updateJenis'])->name('layanan-master.jenis.update');
        Route::delete('jenis/{jenisLayanan}', [LayananMasterController::class, 'destroyJenis'])->name('layanan-master.jenis.destroy');

        // Layanan Kiloan
        Route::get('kiloan/create', [LayananMasterController::class, 'createKiloan'])->name('layanan-master.kiloan.create');
        Route::post('kiloan', [LayananMasterController::class, 'storeKiloan'])->name('layanan-master.kiloan.store');
        Route::get('kiloan/{layananKiloan}/edit', [LayananMasterController::class, 'editKiloan'])->name('layanan-master.kiloan.edit');
        Route::put('kiloan/{layananKiloan}', [LayananMasterController::class, 'updateKiloan'])->name('layanan-master.kiloan.update');
        Route::delete('kiloan/{layananKiloan}', [LayananMasterController::class, 'destroyKiloan'])->name('layanan-master.kiloan.destroy');

        // Layanan Satuan
        Route::get('satuan/create', [LayananMasterController::class, 'createSatuan'])->name('layanan-master.satuan.create');
        Route::post('satuan', [LayananMasterController::class, 'storeSatuan'])->name('layanan-master.satuan.store');
        Route::get('satuan/{layananSatuan}/edit', [LayananMasterController::class, 'editSatuan'])->name('layanan-master.satuan.edit');
        Route::put('satuan/{layananSatuan}', [LayananMasterController::class, 'updateSatuan'])->name('layanan-master.satuan.update');
        Route::delete('satuan/{layananSatuan}', [LayananMasterController::class, 'destroySatuan'])->name('layanan-master.satuan.destroy');
    });
});

// MITRA
Route::prefix('mitra')->middleware(['auth', 'role:mitra'])->name('mitra.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [MitraDashboardController::class, 'index'])->name('dashboard');

    // CRUD untuk mitra
    Route::resource('jam-operasional', JamOperasionalController::class);
    Route::resource('layanan-kiloan', MitraLayananKiloanController::class);
    Route::resource('layanan-satuan', MitraLayananSatuanController::class);
    Route::resource('employee', MitraEmployeeController::class);
    Route::resource('walkin-customers', MitraWalkinCustomerController::class);

    // Pesanan hanya index, create, store, show
    Route::resource('pesanan', MitraPesananController::class)->only(['index', 'create', 'store', 'show']);

    // Tagihan — tambah edit dan update agar route update tidak error
    Route::get('tagihan', [MitraTagihanController::class, 'index'])->name('tagihan.index');
    Route::get('tagihan/{tagihan}', [MitraTagihanController::class, 'show'])->name('tagihan.show');
    Route::get('tagihan/{tagihan}/edit', [MitraTagihanController::class, 'edit'])->name('tagihan.edit');
    Route::put('tagihan/{tagihan}', [MitraTagihanController::class, 'update'])->name('tagihan.update');

    // Transaksi — perbaikan nama route agar sesuai blade yang meletakkan di mitra/transaksi/index.blade.php
    Route::get('transaksi', [RiwayatTransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('transaksi/{transaksi}', [RiwayatTransaksiController::class, 'show'])->name('transaksi.show');

    // Tracking Status
    Route::get('tracking-status', [TrackingStatusController::class, 'index'])->name('tracking_status.index');

    // Profil
    Route::get('/profil', [MitraProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [MitraProfilController::class, 'update'])->name('profil.update');

    // Jadwal Antar Jemput
Route::get('jadwal', [MitraPesananController::class, 'jadwalAntarJemput'])->name('jadwal.index');


    // Konfirmasi Timbangan
    Route::post('/pesanan/{pesanan}/konfirmasi-timbangan', [PelangganPesananController::class, 'konfirmasiTimbangan'])->name('pesanan.konfirmasi.timbangan');
});


// EMPLOYEE
Route::prefix('employee')->middleware(['auth'])->name('employee.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/create', [PesananController::class, 'create'])->name('pesanan.create');
    Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');
    Route::get('/pesanan/{pesanan}', [PesananController::class, 'show'])->name('pesanan.show');

    Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
    Route::get('/tagihan/{tagihan}', [TagihanController::class, 'show'])->name('tagihan.show');

    Route::get('/walkin-customer', [WalkinCustomerController::class, 'index'])->name('walkin_customer.index');
    Route::get('/walkin-customer/create', [WalkinCustomerController::class, 'create'])->name('walkin_customer.create');
    Route::post('/walkin-customer', [WalkinCustomerController::class, 'store'])->name('walkin_customer.store');
    Route::get('/walkin-customer/{walkin}', [WalkinCustomerController::class, 'show'])->name('walkin_customer.show');
    Route::get('/walkin-customer/{walkin}/edit', [WalkinCustomerController::class, 'edit'])->name('walkin_customer.edit');
    Route::put('/walkin-customer/{walkin}', [WalkinCustomerController::class, 'update'])->name('walkin_customer.update');
});

// PELANGGAN
Route::prefix('pelanggan')->middleware(['auth', 'role:pelanggan'])->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [PelangganDashboardController::class, 'index'])->name('dashboard');

    Route::get('/mitra', [PelangganMitraController::class, 'index'])->name('mitra.index');
    Route::get('/mitra/{id}', [PelangganMitraController::class, 'show'])->name('mitra.show');

    Route::get('/pesanan', [PelangganPesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/create/{mitra}', [PelangganPesananController::class, 'create'])->name('pesanan.create');
    Route::post('/pesanan/{mitra}', [PelangganPesananController::class, 'store'])->name('pesanan.store');
    Route::get('/pesanan/{pesanan}', [PelangganPesananController::class, 'show'])->name('pesanan.show');
    Route::get('/pesanan/{pesanan}/pelunasan', [PelangganPesananController::class, 'pelunasan'])->name('pesanan.pelunasan');

    Route::get('/tagihan', [PelangganTagihanController::class, 'index'])->name('tagihan.index');
    Route::get('/tagihan/{tagihan}', [PelangganTagihanController::class, 'show'])->name('tagihan.show');
    Route::get('/tagihan/{tagihan}/bayar', [PelangganPesananController::class, 'bayarDp'])->name('tagihan.bayar');
    Route::post('/tagihan/midtrans/callback', [PelangganPesananController::class, 'callback'])->name('tagihan.callback');

    Route::get('/profil/edit', [PelangganProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [PelangganProfilController::class, 'update'])->name('profil.update');
});

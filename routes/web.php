<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\MidtransCallbackController;

// Superadmin
use App\Http\Controllers\Superadmin\DashboardController as SuperadminDashboardController;
use App\Http\Controllers\Superadmin\UserController;
use App\Http\Controllers\Superadmin\MitraController;
use App\Http\Controllers\Superadmin\LayananMasterController;
use App\Http\Controllers\Superadmin\StatusMasterController;
use App\Http\Controllers\Superadmin\EmployeeController;

// Mitra
use App\Http\Controllers\Mitra\DashboardController as MitraDashboardController;
use App\Http\Controllers\Mitra\ProfilController as MitraProfilController;
use App\Http\Controllers\Mitra\JamOperasionalController;
use App\Http\Controllers\Mitra\LayananKiloanController as MitraLayananKiloanController;
use App\Http\Controllers\Mitra\LayananSatuanController as MitraLayananSatuanController;
use App\Http\Controllers\Mitra\EmployeeController as MitraEmployeeController;
use App\Http\Controllers\Mitra\WalkinCustomerController as MitraWalkinCustomerController;
use App\Http\Controllers\Mitra\PesananController as MitraPesananController;

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
Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handle'])->name('midtrans.callback');

// Auth
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
require __DIR__ . '/auth.php';
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// SUPERADMIN
Route::prefix('superadmin')->middleware(['auth', 'role:superadmin'])->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperadminDashboardController::class, 'index'])->name('dashboard');

    // Mitra - semua di satu menu
    Route::get('/mitras', [MitraController::class, 'index'])->name('mitras.index');
    Route::post('/mitras/approve/{id}', [MitraController::class, 'approve'])->name('mitras.approve');
    Route::post('/mitras/reject/{id}', [MitraController::class, 'reject'])->name('mitras.reject');
    Route::delete('/mitras/{mitra}', [MitraController::class, 'destroy'])->name('mitras.destroy');

    // Employee - hanya index & destroy
    Route::resource('employees', EmployeeController::class)->only(['index', 'destroy']);

    // Users - tetap utuh
    Route::resource('users', UserController::class);

    // Layanan Master
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
Route::prefix('mitra')
    ->middleware(['auth', 'role:mitra'])
    ->name('mitra.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [MitraDashboardController::class, 'index'])->name('dashboard');

        // CRUD utama mitra
        Route::resource('jam-operasional', JamOperasionalController::class);
        Route::resource('layanan-kiloan', MitraLayananKiloanController::class);
        Route::resource('layanan-satuan', MitraLayananSatuanController::class);
        Route::resource('employee', MitraEmployeeController::class);
        Route::resource('walkin-customers', MitraWalkinCustomerController::class);

        // PESANAN (sudah termasuk transaksi, tracking, jadwal, timbangan, tambah pembayaran)
        Route::resource('pesanan', MitraPesananController::class)
            ->only(['index', 'create', 'store', 'show']);

        // Konfirmasi timbangan real
        Route::post('/pesanan/{pesanan}/konfirmasi-timbangan', [MitraPesananController::class, 'konfirmasiTimbangan'])
            ->name('pesanan.konfirmasiTimbangan');

        // Update status
        Route::post('/pesanan/{pesanan}/update-status', [MitraPesananController::class, 'updateStatus'])
            ->name('pesanan.updateStatus');

        // Tambah pembayaran
        Route::post('/pesanan/{tagihan}/tambah-pembayaran', [MitraPesananController::class, 'tambahPembayaran'])
            ->name('pesanan.tambahPembayaran');

        // Jadwal antar jemput
        Route::get('jadwal', [MitraPesananController::class, 'jadwalAntarJemput'])
            ->name('jadwal.index');

        // TRANSAKSI (gabungan di PesananController)
        Route::get('transaksi', [MitraPesananController::class, 'transaksiIndex'])->name('transaksi.index');
        Route::get('transaksi/{pesanan}', [MitraPesananController::class, 'transaksiShow'])->name('transaksi.show');
        Route::get('transaksi/{pesanan}/pelunasan', [MitraPesananController::class, 'pelunasanForm'])->name('transaksi.pelunasan');
        Route::post('transaksi/{pesanan}/pelunasan', [MitraPesananController::class, 'prosesPelunasan'])->name('transaksi.prosesPelunasan');
        Route::post('transaksi/{tagihan}', [MitraPesananController::class, 'storePembayaran'])->name('transaksi.store');

        // PROFIL MITRA
        Route::get('/profil', [MitraProfilController::class, 'edit'])->name('profil.edit');
        Route::put('/profil', [MitraProfilController::class, 'update'])->name('profil.update');
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
    Route::get('/tagihan/{tagihan}/bayar', [PelangganTagihanController::class, 'bayar'])->name('tagihan.bayar');
    Route::get('/profil/edit', [PelangganProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [PelangganProfilController::class, 'update'])->name('profil.update');
});
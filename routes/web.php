<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Superadmin
use App\Http\Controllers\Superadmin\DashboardController as SuperadminDashboardController;
use App\Http\Controllers\Superadmin\UserController;
use App\Http\Controllers\Superadmin\MitraController;
use App\Http\Controllers\Superadmin\EmployeeController as SuperadminEmployeeController;
use App\Http\Controllers\Superadmin\JenisLayananController;
use App\Http\Controllers\Superadmin\LayananKiloanController as SuperadminLayananKiloanController;
use App\Http\Controllers\Superadmin\LayananSatuanController as SuperadminLayananSatuanController;
use App\Http\Controllers\Superadmin\PesananController as SuperadminPesananController;
use App\Http\Controllers\Superadmin\TagihanController as SuperadminTagihanController;
use App\Http\Controllers\Superadmin\TransaksiController as SuperadminTransaksiController;
use App\Http\Controllers\Superadmin\WalkinCustomerController as SuperadminWalkinCustomerController;
use App\Http\Controllers\Superadmin\MitraApprovalController;

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

// Employee
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\Employee\PesananController as EmployeePesananController;
use App\Http\Controllers\Employee\TagihanController as EmployeeTagihanController;
use App\Http\Controllers\Employee\WalkinCustomerController as EmployeeWalkinCustomerController;

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
    Route::resource('employees', SuperadminEmployeeController::class);
    Route::resource('jenis-layanan', JenisLayananController::class);
    Route::resource('layanan-kiloan', SuperadminLayananKiloanController::class);
    Route::resource('layanan-satuan', SuperadminLayananSatuanController::class);
    Route::resource('pesanan', SuperadminPesananController::class);
    Route::resource('tagihan', SuperadminTagihanController::class);
    Route::resource('transaksi', SuperadminTransaksiController::class);
    Route::resource('walkin-customers', SuperadminWalkinCustomerController::class);
});

// MITRA
Route::prefix('mitra')->middleware(['auth', 'role:mitra'])->name('mitra.')->group(function () {
    Route::get('/dashboard', [MitraDashboardController::class, 'index'])->name('dashboard');

    Route::resource('jam-operasional', JamOperasionalController::class);
    Route::resource('layanan-kiloan', MitraLayananKiloanController::class);
    Route::resource('layanan-satuan', MitraLayananSatuanController::class);
    Route::resource('employee', MitraEmployeeController::class);
    Route::resource('walkin-customers', MitraWalkinCustomerController::class);
    Route::resource('pesanan', MitraPesananController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('tagihan', MitraTagihanController::class)->only(['index', 'show']);
    Route::resource('transaksi', RiwayatTransaksiController::class)->only(['index', 'show']);

    Route::get('/profil', [MitraProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [MitraProfilController::class, 'update'])->name('profil.update');

    Route::post('/pesanan/{pesanan}/konfirmasi-timbangan', [PelangganPesananController::class, 'konfirmasiTimbangan'])->name('pesanan.konfirmasi.timbangan');
});

// EMPLOYEE
Route::prefix('employee')->middleware(['auth', 'role:employee'])->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');
    Route::resource('pesanan', EmployeePesananController::class)->only(['index', 'show']);
    Route::resource('tagihan', EmployeeTagihanController::class)->only(['index', 'show']);
    Route::resource('walkin-customer', EmployeeWalkinCustomerController::class);
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

    Route::get('/tagihan', [PelangganTagihanController::class, 'index'])->name('tagihan.index');
    Route::get('/tagihan/{tagihan}', [PelangganTagihanController::class, 'show'])->name('tagihan.show');
    Route::get('/tagihan/{tagihan}/bayar', [PelangganPesananController::class, 'bayarDp'])->name('tagihan.bayar');
    Route::post('/tagihan/midtrans/callback', [PelangganPesananController::class, 'callback'])->name('tagihan.callback');

    Route::get('/profil/edit', [PelangganProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [PelangganProfilController::class, 'update'])->name('profil.update');

    Route::get('/pesanan/{pesanan}/pelunasan', [PelangganPesananController::class, 'pelunasan'])->name('pesanan.pelunasan');
});
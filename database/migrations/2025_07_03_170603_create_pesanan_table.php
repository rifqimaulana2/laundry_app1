<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // user login
    $table->foreignId('walkin_customer_id')->nullable()->constrained('walkin_customer')->onDelete('set null'); // walk-in
    $table->foreignId('mitras_id')->constrained('mitras')->onDelete('cascade');
    $table->enum('jenis_pesanan', ['kiloan', 'satuan', 'gabungan']);
    $table->enum('status_pesanan', ['menunggu', 'dijemput', 'diproses', 'selesai', 'diantar'])->default('menunggu');
    $table->enum('status_konfirmasi', ['pending', 'disetujui', 'ditolak'])->default('pending');
    $table->enum('status_harga', ['belum_final', 'sudah_final'])->default('belum_final');
    $table->enum('status_bayar', ['belum', 'sebagian', 'lunas'])->default('belum');
    $table->integer('dp')->nullable();
    $table->integer('total_harga')->nullable();
    $table->integer('sisa_tagihan')->nullable();
    $table->timestamp('waktu_pesan')->nullable();
    $table->date('tanggal_jemput')->nullable();
    $table->date('tanggal_kirim')->nullable();
    $table->boolean('dijemput_kurir')->default(false);
    $table->text('pesan')->nullable();
    $table->date('jatuh_tempo')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};

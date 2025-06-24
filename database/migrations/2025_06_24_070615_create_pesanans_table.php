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
        Schema::create('pesanans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
    $table->foreignId('walkin_customer_id')->nullable()->constrained('walkin_costumer')->onDelete('set null');
    $table->foreignId('mitra_id')->constrained('mitras')->onDelete('cascade');
    $table->enum('status_pesanan', ['menunggu', 'dijemput', 'diproses', 'selesai', 'diantar'])->default('menunggu');
    $table->enum('status_konfirmasi', ['belum', 'disetujui', 'ditolak'])->default('belum');
    $table->dateTime('waktu_pesan')->nullable();
    $table->date('tanggal_jemput')->nullable();
    $table->date('tanggal_kirim')->nullable();
    $table->enum('dijemput_kurir', ['ya', 'tidak'])->nullable();
    $table->enum('diantar_kurir', ['ya', 'tidak'])->nullable();
    $table->decimal('subtotal', 10, 2)->default(0);
    $table->decimal('dp', 10, 2)->default(0);
    $table->decimal('total_harga', 10, 2)->default(0);
    $table->decimal('sisa_tagihan', 10, 2)->default(0);
    $table->enum('status_bayar', ['lunas', 'belum', 'sebagian'])->default('belum');
    $table->text('keterangan')->nullable();
    $table->date('tanggal_jatuh_tempo')->nullable();
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesananTable extends Migration
{
    public function up()
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable(); // untuk pelanggan terdaftar
            $table->unsignedBigInteger('walkin_customer_id')->nullable(); // untuk pelanggan walk-in
            $table->unsignedBigInteger('mitra_id');

            $table->enum('jenis_pesanan', ['Kiloan', 'Satuan', 'Kiloan + Satuan', 'gabungan']);
            $table->text('catatan_pesanan')->nullable();

            $table->enum('tipe_dp_wajib', ['Ya', 'Tidak'])->default('Tidak');
            $table->enum('tipe_bisa_lunas', ['Ya', 'Tidak'])->default('Tidak');

            $table->date('tanggal_pesan');

            $table->enum('opsi_jemput', ['Ya', 'Tidak'])->default('Tidak');
            $table->dateTime('jadwal_jemput')->nullable();

            $table->enum('opsi_antar', ['Ya', 'Tidak'])->default('Tidak');
            $table->dateTime('jadwal_antar')->nullable();

            $table->text('catatan_pengiriman')->nullable();

            $table->timestamps();

            // Relasi
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('walkin_customer_id')->references('id')->on('walkin_customers')->onDelete('set null');
            $table->foreign('mitra_id')->references('id')->on('mitras')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanans');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatTransaksiTable extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_id');
            $table->unsignedBigInteger('user_id')->nullable(); // karena beberapa NULL
            $table->integer('nominal');
            $table->enum('jenis_transaksi', ['dp', 'pelunasan', 'pembayaran']);
            $table->enum('metode_bayar', ['transfer', 'cash']);
            $table->timestamp('waktu');
            $table->timestamps();

            $table->foreign('pesanan_id')->references('id')->on('pesanans')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_transaksi');
    }
}


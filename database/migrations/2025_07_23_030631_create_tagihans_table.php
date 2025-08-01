<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
            $table->integer('total_tagihan')->nullable();
            $table->integer('dp_dibayar')->default(0);
            $table->integer('sisa_tagihan')->nullable();
            $table->enum('metode_bayar', ['cash', 'transfer']);
            $table->enum('status_pembayaran', ['lunas', 'belum lunas', 'dp_terbayar']);
            $table->date('jatuh_tempo_pelunasan')->nullable();
            $table->dateTime('waktu_bayar_dp')->nullable();
            $table->dateTime('waktu_pelunasan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};

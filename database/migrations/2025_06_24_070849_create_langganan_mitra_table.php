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
        Schema::create('langganan_mitra', function (Blueprint $table) {
    $table->id();
    $table->foreignId('mitra_id')->constrained('mitras')->onDelete('cascade');
    $table->foreignId('paket_langganan_id')->constrained('paket_langganan')->onDelete('cascade');
    $table->date('tanggal_mulai');
    $table->date('tanggal_berakhir');
    $table->enum('status', ['aktif', 'tidak aktif', 'menunggu_pembayaran'])->default('menunggu_pembayaran');
    $table->string('metode_pembayaran')->nullable();
    $table->string('bukti_pembayaran')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('langganan_mitra');
    }
};

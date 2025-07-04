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
        Schema::create('pesanan_detail_satuan', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
    $table->foreignId('layanan_mitra_satuan_id')->constrained('layanan_mitra_satuan')->onDelete('cascade');
    $table->unsignedInteger('jumlah_item');
    $table->unsignedInteger('harga_per_item');
    $table->unsignedInteger('subtotal')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_detail_satuan');
    }
};

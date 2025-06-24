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
        Schema::create('riwayat_transaksi', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
    $table->enum('status', ['dp', 'pelunasan']);
    $table->decimal('jumlah', 10, 2);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_transaksi');
    }
};

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
        Schema::create('tracking_status', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
    $table->foreignId('status_master_id')->constrained('status_master')->onDelete('cascade');
    $table->text('aktivitas')->nullable(); // misalnya: "Barang dijemput oleh kurir"
    $table->timestamp('waktu')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_status');
    }
};

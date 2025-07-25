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
        Schema::create('layanan_mitra_satuan', function (Blueprint $table) {
    $table->id();
    $table->foreignId('mitra_id')->constrained('mitras')->onDelete('cascade');
    $table->foreignId('layanan_satuan_id')->constrained('layanan_satuan')->onDelete('cascade');
    $table->unsignedInteger('harga_per_item');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_mitra_satuan');
    }
};

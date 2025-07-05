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
        Schema::create('paket_langganans', function (Blueprint $table) {
    $table->id();
    $table->string('nama_paket');
    $table->integer('harga');
    $table->integer('durasi'); // Misal dalam hari atau bulan
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_langganans');
    }
};

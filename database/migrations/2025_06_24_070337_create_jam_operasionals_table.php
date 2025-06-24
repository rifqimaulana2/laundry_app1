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
        Schema::create('jam_operasionals', function (Blueprint $table) {
    $table->id();
    $table->foreignId('mitra_id')->constrained('mitras')->onDelete('cascade');
    $table->string('hari_buka'); // Contoh: Senin - Jumat
    $table->time('jam_buka');
    $table->time('jam_tutup');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jam_operasionals');
    }
};

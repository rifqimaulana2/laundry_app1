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
       Schema::create('layanan_mitra_kiloans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('layanan_kiloan_id')->constrained('layanan_kiloans')->onDelete('cascade'); // ✅ gunakan nama tabel yang benar
    $table->foreignId('mitra_id')->constrained('mitras')->onDelete('cascade'); // jika ada
    $table->integer('harga_per_kg'); // opsional
    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_mitra_kiloan');
    }
};

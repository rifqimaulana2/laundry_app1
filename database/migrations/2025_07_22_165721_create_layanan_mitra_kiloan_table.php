<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('layanan_mitra_kiloan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('layanan_kiloan_id')->constrained('layanan_kiloan')->onDelete('cascade');
        $table->foreignId('mitra_id')->constrained('mitras')->onDelete('cascade');
        $table->integer('harga_per_kg');
        $table->integer('durasi_hari');
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

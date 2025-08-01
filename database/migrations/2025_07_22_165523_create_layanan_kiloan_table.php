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
    Schema::create('layanan_kiloan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('jenis_layanan_id')->constrained('jenis_layanan')->onDelete('cascade');
        $table->string('nama_paket');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_kiloan');
    }
};

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
        Schema::create('langganan_mitras', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('mitra_id');
    $table->enum('status', ['aktif', 'tidak']);
    $table->date('tanggal_mulai')->nullable();
    $table->date('tanggal_berakhir')->nullable();
    $table->timestamps();

    $table->foreign('mitra_id')->references('id')->on('mitras')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('langganan_mitras');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tracking_status', function (Blueprint $table) {
            $table->id();

            // Relasi ke pesanan
            $table->foreignId('pesanan_id')->constrained()->onDelete('cascade');

            // Relasi ke status master
            $table->foreignId('status_master_id')->constrained('status_master')->onDelete('cascade');

            // Relasi opsional ke user dan mitra
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('mitra_id')->nullable()->constrained('mitras')->onDelete('set null');

            // Pesan tambahan saat update status
            $table->text('pesan')->nullable();

            // Waktu perubahan status
            $table->timestamp('waktu')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tracking_status');
    }
};

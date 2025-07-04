<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tracking_status', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('pesanan_id')->constrained('users')->onDelete('set null');
            $table->foreignId('mitra_id')->nullable()->after('user_id')->constrained('mitras')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('tracking_status', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['mitra_id']);
            $table->dropColumn(['user_id', 'mitra_id']);
        });
    }
};

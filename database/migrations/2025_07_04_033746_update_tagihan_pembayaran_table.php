<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tagihan_pembayaran', function (Blueprint $table) {
            $table->dropColumn('status'); // jika sebelumnya ada
            $table->enum('status_bayar', ['belum', 'sebagian', 'lunas'])->after('sisa_tagihan');
        });
    }

    public function down(): void
    {
        Schema::table('tagihan_pembayaran', function (Blueprint $table) {
            $table->dropColumn('status_bayar');
            $table->enum('status', ['dp', 'pelunasan', 'cod'])->after('sisa_tagihan'); // untuk rollback
        });
    }
};

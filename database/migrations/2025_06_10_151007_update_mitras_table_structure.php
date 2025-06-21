<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mitras', function (Blueprint $table) {
            if (!Schema::hasColumn('mitras', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
            if (!Schema::hasColumn('mitras', 'toko_id')) {
                $table->unsignedBigInteger('toko_id')->after('user_id');
                $table->foreign('toko_id')->references('id')->on('tokos')->onDelete('cascade');
            }
            if (!Schema::hasColumn('mitras', 'nama')) {
                $table->string('nama')->after('toko_id');
            }
            if (!Schema::hasColumn('mitras', 'alamat')) {
                $table->string('alamat')->after('nama');
            }
            if (!Schema::hasColumn('mitras', 'telepon')) {
                $table->string('telepon')->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('mitras', 'jenis_layanan')) {
                $table->string('jenis_layanan')->nullable()->after('telepon');
            }
            if (!Schema::hasColumn('mitras', 'metode_pembayaran')) {
                $table->string('metode_pembayaran')->nullable()->after('jenis_layanan');
            }
            if (!Schema::hasColumn('mitras', 'status')) {
                $table->string('status')->default('pending')->after('metode_pembayaran');
            }
            if (!Schema::hasColumn('mitras', 'detail_layanan')) {
                $table->text('detail_layanan')->nullable()->after('status');
            }
            if (!Schema::hasColumn('mitras', 'total')) {
                $table->decimal('total', 10, 2)->default(0)->after('detail_layanan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mitras', function (Blueprint $table) {
            if (Schema::hasColumn('mitras', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            $table->dropColumn(['toko_id', 'nama', 'alamat', 'telepon', 'lama', 'metode_pembayaran', 'status', 'total', 'detail_layanan']);
        });
    }
};
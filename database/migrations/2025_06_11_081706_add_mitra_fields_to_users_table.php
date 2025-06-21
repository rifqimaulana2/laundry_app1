<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambahkan field mitra ke tabel users.
     */
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Hapus baris ini jika kolom sudah ada:
        // $table->string('alamat')->nullable();

        // Tambahkan hanya kolom yang belum ada:
        if (!Schema::hasColumn('users', 'no_telepon')) {
            $table->string('no_telepon')->nullable();
        }

        if (!Schema::hasColumn('users', 'kecamatan')) {
            $table->string('kecamatan')->nullable();
        }

        if (!Schema::hasColumn('users', 'foto_profil')) {
            $table->string('foto_profil')->nullable();
        }

        if (!Schema::hasColumn('users', 'is_approved')) {
            $table->boolean('is_approved')->default(true);
        }
    });
}


    /**
     * Rollback field-field tambahan mitra dari tabel users.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'no_telepon',
                'alamat',
                'kecamatan',
                'foto_profil',
                'is_approved'
            ]);
        });
    }
};

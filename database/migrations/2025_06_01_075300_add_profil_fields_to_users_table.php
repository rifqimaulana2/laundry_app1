<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Ubah nama kolom kalau perlu
            if (Schema::hasColumn('users', 'no_whatsapp')) {
                $table->renameColumn('no_whatsapp', 'nomor_whatsapp');
            }

            // Tambah kolom jika belum ada
            if (!Schema::hasColumn('users', 'alamat')) {
                $table->string('alamat')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'foto_profil')) {
                $table->string('foto_profil')->nullable()->after('nomor_whatsapp');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'nomor_whatsapp')) {
                $table->renameColumn('nomor_whatsapp', 'no_whatsapp');
            }
            if (Schema::hasColumn('users', 'alamat')) {
                $table->dropColumn('alamat');
            }
            if (Schema::hasColumn('users', 'foto_profil')) {
                $table->dropColumn('foto_profil');
            }
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tokos', function (Blueprint $table) {
            if (!Schema::hasColumn('tokos', 'gambar')) {
                $table->string('gambar')->nullable()->after('kontak');
            }
            if (!Schema::hasColumn('tokos', 'lat')) {
                $table->decimal('lat', 10, 8)->nullable()->after('gambar');
            }
            if (!Schema::hasColumn('tokos', 'lng')) {
                $table->decimal('lng', 11, 8)->nullable()->after('lat');
            }
            if (!Schema::hasColumn('tokos', 'kecamatan')) {
                $table->string('kecamatan')->nullable()->after('lng');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tokos', function (Blueprint $table) {
            $table->dropColumn(['gambar', 'lat', 'lng', 'kecamatan']);
        });
    }
};
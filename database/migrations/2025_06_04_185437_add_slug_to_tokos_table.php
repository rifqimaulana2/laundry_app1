<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tokos', function (Blueprint $table) {
            // Jangan gunakan 'after' jika tidak yakin kolom 'nama' ada
            $table->string('slug')->unique()->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('tokos', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mitras', function (Blueprint $table) {
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
            $table->dropColumn(['detail_layanan', 'total']);
        });
    }
};
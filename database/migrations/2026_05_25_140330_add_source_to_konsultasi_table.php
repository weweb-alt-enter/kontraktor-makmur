<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('konsultasi', function (Blueprint $table) {
            $table->string('source_type')->nullable()->after('jenis_layanan_id'); // 'portofolio' atau 'inspirasi'
            $table->string('source_slug')->nullable()->after('source_type'); // slug proyek/inspirasi
            $table->string('source_judul')->nullable()->after('source_slug'); // judul proyek/inspirasi
        });
    }

    public function down(): void
    {
        Schema::table('konsultasi', function (Blueprint $table) {
            $table->dropColumn(['source_type', 'source_slug', 'source_judul']);
        });
    }
};
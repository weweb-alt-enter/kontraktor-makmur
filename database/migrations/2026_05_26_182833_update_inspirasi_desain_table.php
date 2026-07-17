<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inspirasi_desain', function (Blueprint $table) {
            // Tambah foreign key
            $table->foreignId('kategori_id')->nullable()->after('gambar')->constrained('kategori_inspirasi')->onDelete('set null');
            $table->foreignId('konsep_id')->nullable()->after('kategori_id')->constrained('konsep_inspirasi')->onDelete('set null');
            
            // Hapus kolom string lama (opsional, bisa dihapus nanti)
            // $table->dropColumn(['kategori', 'konsep']);
        });
    }

    public function down(): void
    {
        Schema::table('inspirasi_desain', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropForeign(['konsep_id']);
            $table->dropColumn(['kategori_id', 'konsep_id']);
        });
    }
};
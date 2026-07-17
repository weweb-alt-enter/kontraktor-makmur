<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portofolio_proyek', function (Blueprint $table) {
            $table->id();
            $table->string('nama_proyek');
            $table->string('slug')->unique();
            $table->foreignId('jenis_layanan_id')->nullable()->constrained('jenis_layanan')->onDelete('set null');
            $table->foreignId('jenis_bangunan_id')->nullable()->constrained('jenis_bangunan')->onDelete('set null');
            $table->decimal('estimasi_budget', 15, 0)->nullable();
            $table->text('lokasi');
            $table->decimal('koordinat_lat', 10, 8)->nullable();
            $table->decimal('koordinat_lng', 11, 8)->nullable();
            $table->integer('luas_bangunan')->nullable();
            $table->string('durasi_pengerjaan')->nullable();
            $table->year('tahun_selesai')->nullable();
            $table->string('klien_nama')->nullable();
            $table->longText('deskripsi');
            $table->enum('status_proyek', ['selesai', 'berjalan', 'direncanakan'])->default('selesai');
            $table->boolean('is_featured')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portofolio_proyek');
    }
};
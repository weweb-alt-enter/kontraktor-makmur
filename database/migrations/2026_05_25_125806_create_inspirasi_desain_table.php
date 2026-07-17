<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspirasi_desain', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable(); // Featured image
            $table->string('kategori')->nullable(); // Contoh: Minimalis, Modern, Klasik, Industrial
            $table->string('konsep')->nullable(); // Contoh: Scandinavian, Japandi, Industrial
            $table->string('warna_dominan')->nullable(); // Contoh: Putih, Abu-abu, Navy
            $table->integer('estimasi_biaya')->nullable(); // Estimasi biaya per m²
            $table->text('tags')->nullable(); // Tags dipisahkan koma
            $table->boolean('is_published')->default(false);
            $table->datetime('published_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspirasi_desain');
    }
};
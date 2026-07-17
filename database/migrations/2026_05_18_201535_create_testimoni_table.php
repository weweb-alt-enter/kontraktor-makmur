<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimoni', function (Blueprint $table) {
            $table->id();
            $table->string('nama_client');
            $table->string('foto_client')->nullable();
            $table->text('isi_testimoni');
            $table->integer('rating')->comment('1-5');
            $table->foreignId('portofolio_id')->nullable()->constrained('portofolio_proyek')->onDelete('set null');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimoni');
    }
};
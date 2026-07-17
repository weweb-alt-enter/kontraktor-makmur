<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portofolio_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portofolio_id')->constrained('portofolio_proyek')->onDelete('cascade');
            $table->string('image_path');
            $table->string('caption')->nullable();
            $table->boolean('is_before')->default(false);
            $table->foreignId('before_image_id')->nullable()->constrained('portofolio_galleries')->onDelete('set null');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portofolio_galleries');
    }
};
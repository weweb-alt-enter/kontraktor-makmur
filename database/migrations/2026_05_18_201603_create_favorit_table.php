<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorit', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->foreignId('portofolio_id')->constrained('portofolio_proyek')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['session_id', 'portofolio_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorit');
    }
};
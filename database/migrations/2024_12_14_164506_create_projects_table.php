<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('umkm_id'); // Relasi ke tabel umkms
            $table->string('title'); // Judul proyek
            $table->text('description'); // Deskripsi proyek
            $table->date('deadline'); // Tenggat waktu pengumpulan dana
            $table->string('status')->default('open'); // Status proyek
            $table->string('portfolio')->nullable(); // Portfolio proyek
            $table->string('photo')->nullable(); // Photo proyek
            $table->timestamps();
    
            $table->foreign('umkm_id')->references('id')->on('umkms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

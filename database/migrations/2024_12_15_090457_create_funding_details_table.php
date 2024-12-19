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
        Schema::create('funding_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->decimal('target_pendanaan', 15, 2);
            $table->decimal('dana_terkumpul', 15, 2)->default(0);
            $table->decimal('sisa_pendanaan', 15, 2)->virtualAs('target_pendanaan - dana_terkumpul');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funding_details');
    }
};

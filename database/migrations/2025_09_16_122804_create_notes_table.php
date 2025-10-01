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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();

            $table->decimal('noteSessionNormale', 5, 2)->nullable(); // Note entre 0 et 
            $table->decimal('noteRattrapage', 5, 2)->nullable(); // Note entre 0 et 20
            $table->foreignId('inscriptionId')->constrained('inscriptions')->cascadeOnDelete();
            $table->foreignId('ecueId')->constrained('modules')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};

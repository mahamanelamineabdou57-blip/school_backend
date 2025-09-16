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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name');   // ex: Algorithmique
            $table->string('code')->unique(); // ex: INFO101

            $table->foreignId('section_module_id')
                ->constrained('sections')
                ->cascadeOnDelete();

            $table->foreignId('enseignant_id')
                ->constrained('enseignants')
                ->cascadeOnDelete();

            $table->integer('credits')->default(0);
            $table->integer('volume_horaire')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};

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

         Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inscriptionId')->constrained('inscriptions')->cascadeOnDelete();
            $table->enum('type', ['inscription', 'formation']);
            $table->decimal('montant', 10, 2);
            $table->date('datePaiement')->nullable();
            $table->enum('statut', ['non payé', 'partiellement payé', 'payé'])->default('non payé');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};

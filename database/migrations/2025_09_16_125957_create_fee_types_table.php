<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Catalogue des types de frais (indépendant de l'étudiant).
     * Remplace l'ancienne table "fees" qui mélangeait catalogue et facture.
     */
    public function up(): void
    {
        Schema::create('fee_types', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['inscription', 'formation']);
            $table->string('libelle'); // ex: "Frais d'inscription 2025-2026"
            $table->decimal('montant_defaut', 10, 2);
            $table->foreignId('academic_year_id')->nullable()->constrained('academic_years')->nullOnDelete();
            $table->foreignId('formation_id')->nullable()->constrained('formations')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_types');
    }
};
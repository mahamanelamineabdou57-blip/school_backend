<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * La "facture" d'un étudiant pour un type de frais donné.
     * Seule table qui porte le solde et le statut de paiement.
     * Fusionne les anciennes tables "fees" (facture) et "student_fees".
     */
    public function up(): void
    {
        Schema::create('student_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('etudiants')->cascadeOnDelete();
            $table->foreignId('inscription_id')->nullable()->constrained('inscriptions')->cascadeOnDelete();
            $table->foreignId('fee_type_id')->constrained('fee_types')->cascadeOnDelete();

            // Montant dû, copié depuis fee_types.montant_defaut à la génération
            // mais modifiable individuellement (bourse, remise, pénalité...).
            $table->decimal('montant_du', 10, 2);

            // Dénormalisé : recalculé depuis payment_histories à chaque versement.
            // Ne jamais modifier ce champ manuellement en dehors du PaymentService.
            $table->decimal('paid_amount', 10, 2)->default(0);

            $table->enum('status', ['pending', 'partial', 'paid'])->default('pending');
            $table->date('payment_date')->nullable(); // date du dernier versement

            $table->timestamps();
            $table->softDeletes();

            // Empêche la génération de deux factures identiques pour le même étudiant.
            $table->unique(
                ['etudiant_id', 'fee_type_id', 'inscription_id'],
                'student_fees_unique_bill'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_fees');
    }
};
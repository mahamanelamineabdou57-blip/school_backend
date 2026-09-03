<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Registre immuable de chaque versement. Source de vérité du montant payé :
     * student_fees.paid_amount est toujours recalculé à partir de cette table.
     */
    public function up(): void
    {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_fee_id')->constrained('student_fees')->cascadeOnDelete();
            $table->foreignId('etudiant_id')->constrained('etudiants')->cascadeOnDelete();
            $table->decimal('montant_verse', 10, 2);
            $table->enum('mode_paiement', ['espèces', 'virement', 'mobile_money', 'chèque'])->default('espèces');
            $table->string('reference')->nullable()->comment('N° reçu ou référence bancaire');
            $table->text('note')->nullable()->comment("Commentaire de l'agent");
            $table->foreignId('enregistre_par')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_histories');
    }
};
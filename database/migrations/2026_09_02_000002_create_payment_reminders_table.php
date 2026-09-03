<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Trace les relances envoyées aux étudiants pour une facture (student_fee) précise.
     * Référencer student_fee_id (et non etudiant_id + fee_id séparément) lève toute
     * ambiguïté quand un étudiant a plusieurs factures du même type (réinscription...).
     */
    public function up(): void
    {
        Schema::create('payment_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_fee_id')->constrained('student_fees')->cascadeOnDelete();
            $table->date('date_relance');
            $table->enum('canal', ['email', 'sms', 'manuel'])->default('manuel');
            $table->enum('statut', ['envoyée', 'échouée', 'en_attente', 'résolue'])->default('en_attente');
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_reminders');
    }
};
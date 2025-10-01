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
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->unique();
            $table->string('nom', 50);
            $table->string('prenom', 50);
            $table->string('email')->unique();
            $table->date('dateNaissance')->nullable();
            $table->string('lieuNaissance')->nullable();
            $table->string('telephone');
            $table->string('adresse')->nullable();
            $table->text('photo')->nullable();
            $table->string('contact_nom')->nullable();
            $table->string('contact_prenom')->nullable();
            $table->string('contact_telephone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_lien')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};

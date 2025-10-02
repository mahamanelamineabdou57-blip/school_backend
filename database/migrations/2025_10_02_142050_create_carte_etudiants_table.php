<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carte_etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('numero_carte')->unique();
            $table->unsignedBigInteger('inscriptions_id');
            $table->date('date_emission')->default(DB::raw('CURRENT_DATE'));
            $table->date('date_expiration')->default(DB::raw("(CURRENT_DATE + INTERVAL '1 year')"));
            $table->string('status')->default('active'); // active, inactive, lost, expired
            $table->foreign('inscriptions_id')->references('id')->on('inscriptions')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carte_etudiants');
    }
};

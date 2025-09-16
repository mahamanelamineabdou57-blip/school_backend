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
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('phone_number');
            $table->string('speciality');
            $table->string('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('grade');
            $table->string('fonction');
            $table->string('photo_url')->nullable();
            $table->string('email')->unique();
            $table->foreignId('departement_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseignants');
    }
};

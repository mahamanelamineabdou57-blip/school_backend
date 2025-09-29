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
        Schema::create('acces', function (Blueprint $table) {
            $table->id();
            $table->string('droits');
            $table->unsignedBigInteger('inteface_id');
            $table->unsignedBigInteger('utilisateur_id');
            $table->foreign('inteface_id')
                ->references('id')
                ->on('intefaces')   // ✅ nom exact de la table
                ->onDelete('cascade');
            $table->foreign('utilisateur_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acces');
    }
};

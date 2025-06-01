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
        Schema::create('exercice', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // exemple : "développé militaire"
            $table->string('details', 1000)->nullable(); // exemple : "développé militaire"
            $table->string('methode'); // "durée" ou "poids"
            $table->string('statut'); // "privé" ou "public"
            $table->integer('id_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercice');
    }
};

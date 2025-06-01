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
        Schema::create('serie', function (Blueprint $table) {
            $table->id();
            $table->integer('id_exercice');
            $table->integer('dificulte'); // exemples : 120(sec), 10(kg)
            $table->integer('id_training'); // exemples : 120(sec), 10(kg)
            $table->integer('nb_reps')->nullable();
            $table->integer('id_user');
            $table->integer('ordre');
            $table->boolean('levelup')->default(false);
            $table->boolean('powerup')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serie');
    }
};

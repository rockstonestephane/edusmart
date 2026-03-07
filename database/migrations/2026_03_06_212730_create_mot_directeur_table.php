<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mot_directeur', function (Blueprint $table) {
            $table->id();
            $table->string('nom');                  // Nom complet du directeur
            $table->string('poste');                // Ex: "Directeur Général"
            $table->text('texte');                  // Le message/discours
            $table->string('photo')->nullable();    // Chemin photo (stockage)
            $table->string('signature')->nullable();// Chemin signature (optionnel)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mot_directeur');
    }
};
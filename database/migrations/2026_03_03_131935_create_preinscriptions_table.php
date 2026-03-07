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
          Schema::create('preinscriptions', function (Blueprint $table) {
        $table->id();

        // Informations élève
        $table->string('nom');
        $table->string('prenom');
        $table->date('date_naissance');
        $table->string('classe_souhaitee');

        // Informations parent / tuteur
        $table->string('nom_parent');
        $table->string('prenom_parent');
        $table->string('email_parent');
        $table->string('telephone_parent');

        // Documents uploadés
        $table->string('acte_naissance')->nullable();
        $table->string('dernier_bulletin')->nullable();
        $table->string('photo_identite')->nullable();

        // Statut de la candidature
        $table->enum('statut', ['en_attente', 'accepte', 'refuse'])->default('en_attente');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preinscriptions');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentree_scolaire', function (Blueprint $table) {
            $table->id();
            $table->string('annee');                        // ex: 2025-2026
            $table->string('badge_label')->nullable();      // ex: INSCRIPTIONS OUVERTES
            $table->string('titre');                        // ex: Préparez la rentrée
            $table->text('description')->nullable();        // ex: Complétez votre dossier...
            $table->string('btn1_label')->nullable();       // ex: Déposer ma candidature
            $table->string('btn1_url')->nullable();
            $table->string('btn2_label')->nullable();       // ex: Nous contacter
            $table->string('btn2_url')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentree_scolaire');
    }
};
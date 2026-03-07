<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistiques', function (Blueprint $table) {
            $table->id();
            $table->string('icone')->nullable();          // ex: 🎓 ou nom classe CSS
            $table->string('valeur');                     // ex: 2500
            $table->string('suffixe')->nullable();        // ex: +, %, ans
            $table->string('label');                      // ex: Élèves inscrits
            $table->integer('ordre')->default(1);
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistiques');
    }
};
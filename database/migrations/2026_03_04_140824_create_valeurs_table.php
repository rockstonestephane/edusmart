<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('valeurs', function (Blueprint $table) {
            $table->id();
            $table->string('icone')->nullable();
            $table->string('titre');
            $table->text('description');
            $table->string('couleur')->default('from-blue-500 to-blue-700');
            $table->integer('ordre')->default(1);
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('valeurs');
    }
};
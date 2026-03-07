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
    Schema::create('equipe', function (Blueprint $table) {
        $table->id();
        $table->string('photo')->nullable();
        $table->string('nom');
        $table->string('poste');
        $table->text('bio')->nullable();
        $table->integer('ordre')->default(1);
        $table->boolean('actif')->default(true);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('equipe');
}
};

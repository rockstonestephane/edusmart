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
    DB::statement("ALTER TABLE preinscriptions MODIFY statut VARCHAR(50) DEFAULT 'en_attente'");
}

public function down(): void
{
    DB::statement("ALTER TABLE preinscriptions MODIFY statut ENUM('en_attente','validee','refusee','en_cours') DEFAULT 'en_attente'");
}
};

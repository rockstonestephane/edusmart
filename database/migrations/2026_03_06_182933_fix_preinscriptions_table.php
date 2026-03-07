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
    Schema::table('preinscriptions', function (Blueprint $table) {
        // Renommer
        $table->renameColumn('classe_souhaitee', 'classe_demandee');
        $table->renameColumn('dernier_bulletin', 'bulletin');

        // Ajouter les manquantes
        $table->string('annee_scolaire')->nullable()->after('classe_demandee');
        $table->string('adresse')->nullable()->after('email_parent');
        $table->text('message')->nullable()->after('adresse');
    });
}

public function down(): void
{
    Schema::table('preinscriptions', function (Blueprint $table) {
        $table->renameColumn('classe_demandee', 'classe_souhaitee');
        $table->renameColumn('bulletin', 'dernier_bulletin');
        $table->dropColumn(['annee_scolaire', 'adresse', 'message']);
    });
}
};

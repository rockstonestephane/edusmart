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
    Schema::table('galeries', function (Blueprint $table) {
        $table->string('legende')->nullable()->after('image');
        $table->string('categorie')->nullable()->after('legende');
    });
}

public function down(): void
{
    Schema::table('galeries', function (Blueprint $table) {
        $table->dropColumn(['legende', 'categorie']);
    });
}
};

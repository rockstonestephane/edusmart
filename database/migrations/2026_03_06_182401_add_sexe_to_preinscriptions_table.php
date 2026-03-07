<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('preinscriptions', function (Blueprint $table) {
            $table->string('sexe')->nullable()->after('date_naissance');
        });
    }

    public function down(): void
    {
        Schema::table('preinscriptions', function (Blueprint $table) {
            $table->dropColumn('sexe');
        });
    }
};
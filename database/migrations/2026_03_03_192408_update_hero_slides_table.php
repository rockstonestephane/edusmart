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
    Schema::table('hero_slides', function (Blueprint $table) {
        $table->string('surtitre')->nullable()->after('id');
        $table->text('description')->nullable()->after('titre');

        $table->string('btn1_label')->nullable()->after('image');
        $table->string('btn1_url')->nullable();

        $table->string('btn2_label')->nullable();
        $table->string('btn2_url')->nullable();
    });
}

public function down(): void
{
    Schema::table('hero_slides', function (Blueprint $table) {
        $table->dropColumn([
            'surtitre',
            'description',
            'btn1_label',
            'btn1_url',
            'btn2_label',
            'btn2_url'
        ]);
    });
}
};

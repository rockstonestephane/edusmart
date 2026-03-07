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
    Schema::create('about_page', function (Blueprint $table) {
        $table->id();
        $table->string('hero_image')->nullable();
        $table->text('histoire_p1')->nullable();
        $table->text('histoire_p2')->nullable();
        $table->text('histoire_p3')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('about_page');
}
};

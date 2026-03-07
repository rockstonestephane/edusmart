<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('formations', function (Blueprint $table) {

            $table->text('extrait')->nullable()->after('titre');
            $table->text('contenu')->nullable()->after('extrait');

            $table->string('icon')->nullable()->after('image');
            $table->string('color')->nullable()->after('icon');

            $table->json('tags')->nullable()->after('color');

            $table->string('slug')->unique()->after('titre');
        });
    }

    public function down(): void
    {
        Schema::table('formations', function (Blueprint $table) {

            $table->dropColumn([
                'extrait',
                'contenu',
                'icon',
                'color',
                'tags',
                'slug'
            ]);
        });
    }
};
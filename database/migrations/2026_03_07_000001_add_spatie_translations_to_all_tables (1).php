<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $this->convertColumns('hero_slides', [
            'surtitre'    => 'string',
            'titre'       => 'string',
            'description' => 'text',
            'btn1_label'  => 'string',
            'btn2_label'  => 'string',
        ]);

        $this->convertColumns('actualites', [
            'titre'   => 'string',
            'extrait' => 'text',
            'contenu' => 'text',
        ]);

        $this->convertColumns('formations', [
            'titre'   => 'string',
            'extrait' => 'text',
            'contenu' => 'text',
        ]);

        $this->convertColumns('temoignages', [
            'texte' => 'text',
            'role'  => 'string',
        ]);

        $this->convertColumns('statistiques', [
            'label' => 'string',
        ]);

        $this->convertColumns('rentree_scolaire', [
            'badge_label' => 'string',
            'titre'       => 'string',
            'description' => 'text',
            'btn1_label'  => 'string',
            'btn2_label'  => 'string',
        ]);

        $this->convertColumns('valeurs', [
            'titre'       => 'string',
            'description' => 'text',
        ]);

        $this->convertColumns('equipe', [
            'poste' => 'string',
            'bio'   => 'text',
        ]);

        $this->convertColumns('about_page', [
            'histoire_p1' => 'text',
            'histoire_p2' => 'text',
            'histoire_p3' => 'text',
        ]);

        $this->convertColumns('mot_directeur', [
            'texte' => 'text',
            'poste' => 'string',
        ]);

        $this->convertColumns('documents', [
            'nom'         => 'string',
            'description' => 'string',
        ]);

        $this->convertColumns('galeries', [
            'titre'   => 'string',
            'legende' => 'string',
        ]);
    }

    public function down(): void
    {
        $this->restoreColumns('hero_slides', ['surtitre' => 'string', 'titre' => 'string', 'description' => 'text', 'btn1_label' => 'string', 'btn2_label' => 'string']);
        $this->restoreColumns('actualites', ['titre' => 'string', 'extrait' => 'text', 'contenu' => 'text']);
        $this->restoreColumns('formations', ['titre' => 'string', 'extrait' => 'text', 'contenu' => 'text']);
        $this->restoreColumns('temoignages', ['texte' => 'text', 'role' => 'string']);
        $this->restoreColumns('statistiques', ['label' => 'string']);
        $this->restoreColumns('rentree_scolaire', ['badge_label' => 'string', 'titre' => 'string', 'description' => 'text', 'btn1_label' => 'string', 'btn2_label' => 'string']);
        $this->restoreColumns('valeurs', ['titre' => 'string', 'description' => 'text']);
        $this->restoreColumns('equipe', ['poste' => 'string', 'bio' => 'text']);
        $this->restoreColumns('about_page', ['histoire_p1' => 'text', 'histoire_p2' => 'text', 'histoire_p3' => 'text']);
        $this->restoreColumns('mot_directeur', ['texte' => 'text', 'poste' => 'string']);
        $this->restoreColumns('documents', ['nom' => 'string', 'description' => 'string']);
        $this->restoreColumns('galeries', ['titre' => 'string', 'legende' => 'string']);
    }

    private function convertColumns(string $table, array $columns): void
    {
        foreach ($columns as $column => $type) {

            $newCol = $column . '_json';

            // 1. Ajouter la nouvelle colonne JSON
            Schema::table($table, function (Blueprint $t) use ($newCol) {
                $t->json($newCol)->nullable();
            });

            // 2. Copier les données encodées en JSON {"fr": "valeur"}
            DB::statement("
                UPDATE `{$table}`
                SET `{$newCol}` = JSON_OBJECT('fr', CAST(`{$column}` AS CHAR))
                WHERE `{$column}` IS NOT NULL AND `{$column}` != ''
            ");

            // 3. Supprimer l'ancienne colonne
            Schema::table($table, function (Blueprint $t) use ($column) {
                $t->dropColumn($column);
            });

            // 4. Renommer la colonne JSON avec le nom original
            Schema::table($table, function (Blueprint $t) use ($column, $newCol) {
                $t->renameColumn($newCol, $column);
            });
        }
    }

    private function restoreColumns(string $table, array $columns): void
    {
        foreach ($columns as $column => $type) {

            $newCol = $column . '_restore';

            Schema::table($table, function (Blueprint $t) use ($newCol, $type) {
                if ($type === 'text') {
                    $t->text($newCol)->nullable();
                } else {
                    $t->string($newCol, 500)->nullable();
                }
            });

            DB::statement("
                UPDATE `{$table}`
                SET `{$newCol}` = JSON_UNQUOTE(JSON_EXTRACT(`{$column}`, '$.fr'))
                WHERE `{$column}` IS NOT NULL
            ");

            Schema::table($table, function (Blueprint $t) use ($column) {
                $t->dropColumn($column);
            });

            Schema::table($table, function (Blueprint $t) use ($column, $newCol) {
                $t->renameColumn($newCol, $column);
            });
        }
    }
};

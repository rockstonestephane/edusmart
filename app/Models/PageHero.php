<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PageHero extends Model
{
    protected $table = 'page_heroes';

    protected $fillable = [
        'page',
        'image',
    ];

    /**
     * Récupère le hero d'une page donnée.
     * Si la ligne n'existe pas, on la crée automatiquement.
     */
    public static function getForPage(string $page): self
    {
        return self::firstOrCreate(['page' => $page]);
    }

    /**
     * Retourne l'URL publique de l'image ou null.
     */
    public function imageUrl(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }
}
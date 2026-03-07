<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Actualite extends Model
{
    use HasTranslations;

    public array $translatable = [
        'titre',
        'extrait',
        'contenu',
    ];

    protected $fillable = [
        'titre',
        'slug',
        'extrait',
        'contenu',
        'image',
        'categorie',
        'publiee',
        'published_at',
    ];

    protected $casts = [
        'publiee'      => 'boolean',
        'published_at' => 'datetime',
    ];

    // Génère automatiquement le slug depuis le titre (version FR)
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($actualite) {
            if (empty($actualite->slug)) {
                $actualite->slug = Str::slug($actualite->getTranslation('titre', 'fr'));
            }
            if (empty($actualite->published_at)) {
                $actualite->published_at = now();
            }
        });
    }
}
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Formation extends Model
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
        'icon',
        'color',
        'tags',
        'ordre',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'ordre'  => 'integer',
        'tags'   => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($formation) {
            if (empty($formation->slug)) {
                $formation->slug = Str::slug($formation->getTranslation('titre', 'fr'));
            }
        });
    }
}
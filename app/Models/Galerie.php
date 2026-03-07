<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Galerie extends Model
{
    use HasTranslations;

    public array $translatable = [
        'titre',
        'legende',
    ];

    protected $fillable = [
        'titre',
        'image',
        'legende',
        'categorie',
        'homepage',
        'ordre',
    ];

    protected $casts = [
        'homepage' => 'boolean',
        'ordre'    => 'integer',
    ];
}
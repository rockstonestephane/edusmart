<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class HeroSlide extends Model
{
    use HasTranslations;

    protected $table = 'hero_slides';

    public array $translatable = [
        'surtitre',
        'titre',
        'description',
        'btn1_label',
        'btn2_label',
    ];

    protected $fillable = [
        'surtitre',
        'titre',
        'description',
        'image',
        'btn1_label',
        'btn1_url',
        'btn2_label',
        'btn2_url',
        'ordre',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
        'ordre' => 'integer',
    ];
}
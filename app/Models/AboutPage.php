<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AboutPage extends Model
{
    use HasTranslations;

    protected $table = 'about_page';

    public array $translatable = [
        'histoire_p1',
        'histoire_p2',
        'histoire_p3',
    ];

    protected $fillable = [
        'hero_image',
        'histoire_p1',
        'histoire_p2',
        'histoire_p3',
    ];

    /**
     * Récupère la configuration unique de la page about.
     * Si elle n'existe pas, on la crée automatiquement.
     */
    public static function getInstance(): self
    {
        return self::firstOrCreate(['id' => 1]);
    }
}
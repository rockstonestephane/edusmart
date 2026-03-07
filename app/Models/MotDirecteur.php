<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class MotDirecteur extends Model
{
    use HasTranslations;

    protected $table = 'mot_directeur';

    public array $translatable = [
        'poste',
        'texte',
    ];

    protected $fillable = [
        'nom',
        'poste',
        'texte',
        'photo',
        'signature',
    ];
}
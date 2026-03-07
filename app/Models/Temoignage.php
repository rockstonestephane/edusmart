<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Temoignage extends Model
{
    use HasTranslations;

    public array $translatable = [
        'role',
        'texte',
    ];

    protected $fillable = [
        'nom',
        'role',
        'texte',
        'photo',
        'note',
        'ordre',
        'publie',
    ];

    protected $casts = [
        'publie' => 'boolean',
        'ordre'  => 'integer',
        'note'   => 'integer',
    ];
}
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Valeur extends Model
{
    use HasTranslations;

    public array $translatable = [
        'titre',
        'description',
    ];

    protected $fillable = [
        'icone',
        'titre',
        'description',
        'couleur',
        'ordre',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function scopeActif($query)
    {
        return $query->where('actif', true)->orderBy('ordre');
    }
}
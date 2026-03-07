<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Statistique extends Model
{
    use HasTranslations;

    public array $translatable = [
        'label',
    ];

    protected $fillable = [
        'icone',
        'valeur',
        'suffixe',
        'label',
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
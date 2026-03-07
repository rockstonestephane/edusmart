<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Equipe extends Model
{
    use HasTranslations;

    protected $table = 'equipe';

    public array $translatable = [
        'poste',
        'bio',
    ];

    protected $fillable = [
        'photo',
        'nom',
        'poste',
        'bio',
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
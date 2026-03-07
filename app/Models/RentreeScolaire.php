<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class RentreeScolaire extends Model
{
    use HasTranslations;

    protected $table = 'rentree_scolaire';

    public array $translatable = [
        'badge_label',
        'titre',
        'description',
        'btn1_label',
        'btn2_label',
    ];

    protected $fillable = [
        'annee',
        'badge_label',
        'titre',
        'description',
        'btn1_label',
        'btn1_url',
        'btn2_label',
        'btn2_url',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('actif', true)->latest();
    }
}
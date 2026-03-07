<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class Document extends Model
{
    use HasTranslations;

    public array $translatable = [
        'nom',
        'description',
    ];

    protected $fillable = [
        'nom', 'description', 'categorie',
        'fichier', 'type_fichier', 'taille_fichier',
        'actif', 'ordre',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    // Scopes
    public function scopeActif($query)
    {
        return $query->where('actif', true)->orderBy('ordre');
    }

    public function scopeParCategorie($query, $categorie)
    {
        return $query->actif()->where('categorie', $categorie);
    }

    // Helpers
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->fichier);
    }

    public function getTailleFormatteeAttribute(): string
    {
        if (!$this->taille_fichier) return '';
        if ($this->taille_fichier >= 1024) {
            return round($this->taille_fichier / 1024, 1) . ' Mo';
        }
        return $this->taille_fichier . ' Ko';
    }

    public function getIconeAttribute(): string
    {
        return match($this->type_fichier) {
            'pdf'             => '📄',
            'docx', 'doc'    => '📝',
            'xlsx', 'xls'    => '📊',
            default           => '📁',
        };
    }

    public function getCouleurAttribute(): string
    {
        return match($this->type_fichier) {
            'pdf'             => '#ef4444',
            'docx', 'doc'    => '#2952f5',
            'xlsx', 'xls'    => '#22c55e',
            default           => '#f5c842',
        };
    }
}
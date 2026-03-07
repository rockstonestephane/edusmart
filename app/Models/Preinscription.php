<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preinscription extends Model
{
    protected $fillable = [
    
    'nom', 'prenom', 'date_naissance', 'sexe',
    'classe_demandee', 'annee_scolaire',
    'nom_parent', 'telephone_parent', 'email_parent',
    'adresse', 'message', 'statut',
    'acte_naissance', 'bulletin',

    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    // Statuts disponibles
    const STATUTS = [
        'en_attente' => 'En attente',
        'validee'    => 'Validée',
        'refusee'    => 'Refusée',
        'en_cours'   => 'En cours de traitement',
    ];
}
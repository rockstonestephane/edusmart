<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'nom',
        'email',
        'sujet',
        'message',
        'lu',
        'lu_at',
    ];

    protected $casts = [
        'lu'    => 'boolean',
        'lu_at' => 'datetime',
    ];

    // Scopes
    public function scopeNonLus($query)
    {
        return $query->where('lu', false);
    }

    public function scopeLus($query)
    {
        return $query->where('lu', true);
    }

    // Marquer comme lu
    public function marquerLu(): void
    {
        $this->update([
            'lu'    => true,
            'lu_at' => now(),
        ]);
    }
}
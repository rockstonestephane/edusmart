<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'email',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];
}
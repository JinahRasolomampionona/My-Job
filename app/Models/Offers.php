<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{
    protected $fillable = [
        'titre', 'entreprise', 'contrat', 'localisation', 'domaine', 'description',
        'status', 'is_urgent', 'user_id'
    ];
}

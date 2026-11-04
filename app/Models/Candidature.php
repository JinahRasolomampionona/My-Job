<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidature extends Model
{
    protected $fillable = ['user_id', 'offer_id', 'message'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function offre(): BelongsTo
    {
        return $this->belongsTo(Offers::class, 'offer_id');
    }
}

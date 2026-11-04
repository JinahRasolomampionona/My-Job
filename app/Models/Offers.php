<?php

namespace App\Models;

use App\Support\HtmlSanitizer;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offers extends Model
{
    public const STATUS_EN_ATTENTE = 'en attente';
    public const STATUS_VALIDEE = 'validee';
    public const STATUS_REFUSEE = 'refusee';

    protected $fillable = [
        'titre', 'entreprise', 'contrat', 'localisation', 'domaine', 'description',
        'status', 'is_urgent', 'user_id'
    ];

    protected function casts(): array
    {
        return [
            'is_urgent' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class, 'offer_id');
    }

    public function scopeValidees($query)
    {
        return $query->where('status', self::STATUS_VALIDEE);
    }

    public function isValidee(): bool
    {
        return $this->status === self::STATUS_VALIDEE;
    }

    /**
     * Description nettoyée, à utiliser dans les vues avec {!! $offre->description_html !!}
     */
    protected function descriptionHtml(): Attribute
    {
        return Attribute::get(fn () => HtmlSanitizer::clean($this->description));
    }
}

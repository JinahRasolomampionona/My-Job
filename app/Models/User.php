<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;

    public const STATUS_EN_ATTENTE = 'en attente';
    public const STATUS_VALIDEE = 'validee';
    public const STATUS_REFUSEE = 'refusee';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted(): void
    {
        // Les tables liées n'ont pas de clé étrangère en cascade : on nettoie ici
        static::deleting(function (User $user) {
            $user->profil()->delete();
            $user->formations()->delete();
            $user->experiences()->delete();
            $user->offers()->delete();
            $user->notifications()->delete();
        });
    }

    /**
     * Nom de la route de l'espace correspondant au rôle de l'utilisateur.
     */
    public function homeRoute(): string
    {
        return match (true) {
            $this->hasRole('admin') => 'admin.index',
            $this->hasRole('recruteur') => 'recruiters.recruiter',
            $this->hasRole('candidat') => 'candidates.candidate',
            default => 'index',
        };
    }

    public function profil(): HasOne
    {
        return $this->hasOne(Profil::class, 'user_id');
    }

    public function formations(): HasMany
    {
        return $this->hasMany(Formation::class, 'user_id');
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class, 'user_id');
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offers::class, 'user_id');
    }

    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class, 'user_id');
    }
}

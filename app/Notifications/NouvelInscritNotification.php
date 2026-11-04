<?php

namespace App\Notifications;

use App\Models\User;

/**
 * Prévient les administrateurs qu'un nouvel utilisateur s'est inscrit.
 */
class NouvelInscritNotification extends BaseNotification
{
    protected bool $sendMail = false;

    public function __construct(public User $utilisateur)
    {
    }

    protected function titre(): string
    {
        return 'Nouvel inscrit';
    }

    protected function message(object $notifiable): string
    {
        return "{$this->utilisateur->name} vient de s'inscrire en tant que {$this->utilisateur->role}.";
    }

    protected function lien(object $notifiable): string
    {
        return $this->utilisateur->role === 'recruteur'
            ? route('admin.recruiters', [], false)
            : route('admin.candidates', [], false);
    }

    protected function icone(): string
    {
        return 'fa-user-plus';
    }

    protected function couleur(): string
    {
        return 'info';
    }
}

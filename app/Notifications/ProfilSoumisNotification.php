<?php

namespace App\Notifications;

use App\Models\User;

/**
 * Prévient les administrateurs qu'un candidat a créé ou modifié son profil.
 */
class ProfilSoumisNotification extends BaseNotification
{
    protected bool $sendMail = false;

    public function __construct(public User $candidat, public bool $modification = false)
    {
    }

    protected function titre(): string
    {
        return $this->modification ? 'Profil modifié à revalider' : 'Nouveau profil à valider';
    }

    protected function message(object $notifiable): string
    {
        return "Le candidat {$this->candidat->name} a ".($this->modification ? 'modifié' : 'créé').' son profil.';
    }

    protected function lien(object $notifiable): string
    {
        return route('admin.profils.show', $this->candidat, false);
    }

    protected function icone(): string
    {
        return 'fa-id-card';
    }

    protected function couleur(): string
    {
        return 'warning';
    }
}

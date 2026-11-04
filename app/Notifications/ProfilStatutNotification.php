<?php

namespace App\Notifications;

use App\Models\User;

/**
 * Informe le candidat que son profil a été validé ou refusé.
 * Remplace les anciens Mailables ProfilValide / ProfilRefuse.
 */
class ProfilStatutNotification extends BaseNotification
{
    public function __construct(public string $status)
    {
    }

    private function estValide(): bool
    {
        return $this->status === User::STATUS_VALIDEE;
    }

    protected function titre(): string
    {
        return $this->estValide() ? 'Profil validé' : 'Profil refusé';
    }

    protected function message(object $notifiable): string
    {
        return $this->estValide()
            ? 'Votre profil a été validé ! Il est désormais visible par les recruteurs et vous pouvez postuler aux offres.'
            : 'Votre profil a été refusé. Merci de vérifier et compléter vos informations, il sera ensuite réexaminé.';
    }

    protected function lien(object $notifiable): string
    {
        return route('candidates.profils.profil', [], false);
    }

    protected function icone(): string
    {
        return $this->estValide() ? 'fa-user-check' : 'fa-user-xmark';
    }

    protected function couleur(): string
    {
        return $this->estValide() ? 'success' : 'danger';
    }

    protected function texteBouton(): string
    {
        return 'Voir mon profil';
    }
}

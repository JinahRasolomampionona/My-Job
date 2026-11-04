<?php

namespace App\Notifications;

use App\Models\Candidature;

/**
 * Prévient le recruteur qu'un candidat a postulé à l'une de ses offres.
 */
class NouvelleCandidatureNotification extends BaseNotification
{
    public function __construct(public Candidature $candidature)
    {
    }

    protected function titre(): string
    {
        return 'Nouvelle candidature';
    }

    protected function message(object $notifiable): string
    {
        return "{$this->candidature->user->name} a postulé à votre offre « {$this->candidature->offre->titre} ».";
    }

    protected function lignesEmail(object $notifiable): array
    {
        return $this->candidature->message
            ? ['Message du candidat : « '.$this->candidature->message.' »']
            : [];
    }

    protected function lien(object $notifiable): string
    {
        return route('recruiters.profils.show', $this->candidature->user, false);
    }

    protected function icone(): string
    {
        return 'fa-file-signature';
    }

    protected function couleur(): string
    {
        return 'success';
    }

    protected function texteBouton(): string
    {
        return 'Voir le profil du candidat';
    }
}

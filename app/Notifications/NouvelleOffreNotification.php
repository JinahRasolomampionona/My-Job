<?php

namespace App\Notifications;

use App\Models\Offers;

/**
 * Alerte les candidats qu'une nouvelle offre vient d'être publiée.
 * Uniquement dans l'application (pas d'email) pour éviter les envois massifs.
 */
class NouvelleOffreNotification extends BaseNotification
{
    protected bool $sendMail = false;

    public function __construct(public Offers $offre)
    {
    }

    protected function titre(): string
    {
        return $this->offre->is_urgent ? 'Nouvelle offre urgente' : 'Nouvelle offre';
    }

    protected function message(object $notifiable): string
    {
        return "{$this->offre->entreprise} recrute : {$this->offre->titre} ({$this->offre->localisation}).";
    }

    protected function lien(object $notifiable): string
    {
        return route('candidates.offers.show', $this->offre, false);
    }

    protected function icone(): string
    {
        return 'fa-bullhorn';
    }

    protected function couleur(): string
    {
        return $this->offre->is_urgent ? 'danger' : 'primary';
    }
}

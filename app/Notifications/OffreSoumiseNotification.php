<?php

namespace App\Notifications;

use App\Models\Offers;

/**
 * Prévient les administrateurs qu'une offre (nouvelle ou modifiée) attend une validation.
 */
class OffreSoumiseNotification extends BaseNotification
{
    public function __construct(public Offers $offre, public bool $modification = false)
    {
    }

    protected function titre(): string
    {
        return $this->modification ? 'Offre modifiée à revalider' : 'Nouvelle offre à valider';
    }

    protected function message(object $notifiable): string
    {
        return "L'offre « {$this->offre->titre} » ({$this->offre->entreprise}) attend votre validation.";
    }

    protected function lien(object $notifiable): string
    {
        return route('admin.offers.show', $this->offre, false);
    }

    protected function icone(): string
    {
        return 'fa-briefcase';
    }

    protected function couleur(): string
    {
        return 'warning';
    }

    protected function texteBouton(): string
    {
        return "Examiner l'offre";
    }
}

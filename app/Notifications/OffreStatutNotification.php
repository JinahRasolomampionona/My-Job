<?php

namespace App\Notifications;

use App\Models\Offers;

/**
 * Informe le recruteur que son offre a été validée ou refusée par l'administrateur.
 */
class OffreStatutNotification extends BaseNotification
{
    public function __construct(public Offers $offre)
    {
    }

    protected function titre(): string
    {
        return $this->offre->isValidee() ? 'Offre validée' : 'Offre refusée';
    }

    protected function message(object $notifiable): string
    {
        return $this->offre->isValidee()
            ? "Bonne nouvelle ! Votre offre « {$this->offre->titre} » a été validée et est maintenant visible par les candidats."
            : "Votre offre « {$this->offre->titre} » a été refusée par l'administrateur. Vous pouvez la modifier puis la soumettre à nouveau.";
    }

    protected function lien(object $notifiable): string
    {
        return route('recruiters.offers.show', $this->offre, false);
    }

    protected function icone(): string
    {
        return $this->offre->isValidee() ? 'fa-circle-check' : 'fa-circle-xmark';
    }

    protected function couleur(): string
    {
        return $this->offre->isValidee() ? 'success' : 'danger';
    }
}

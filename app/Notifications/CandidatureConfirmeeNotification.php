<?php

namespace App\Notifications;

use App\Models\Candidature;

/**
 * Confirme au candidat que sa candidature a bien été transmise au recruteur.
 */
class CandidatureConfirmeeNotification extends BaseNotification
{
    public function __construct(public Candidature $candidature)
    {
    }

    protected function titre(): string
    {
        return 'Candidature envoyée';
    }

    protected function message(object $notifiable): string
    {
        $offre = $this->candidature->offre;

        return "Votre candidature pour « {$offre->titre} » chez {$offre->entreprise} a bien été transmise au recruteur.";
    }

    protected function lignesEmail(object $notifiable): array
    {
        return ['Le recruteur vous contactera directement si votre profil correspond. Bonne chance !'];
    }

    protected function lien(object $notifiable): string
    {
        return route('candidates.offers.show', $this->candidature->offre, false);
    }

    protected function icone(): string
    {
        return 'fa-paper-plane';
    }

    protected function couleur(): string
    {
        return 'success';
    }

    protected function texteBouton(): string
    {
        return "Revoir l'offre";
    }
}

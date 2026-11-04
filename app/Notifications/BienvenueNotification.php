<?php

namespace App\Notifications;

/**
 * Email de bienvenue envoyé à l'utilisateur juste après son inscription.
 */
class BienvenueNotification extends BaseNotification
{
    protected bool $sendDatabase = false;

    protected function titre(): string
    {
        return 'Bienvenue sur My-Job';
    }

    protected function message(object $notifiable): string
    {
        return $notifiable->hasRole('recruteur')
            ? "Votre compte recruteur a bien été créé. Vous pouvez dès maintenant publier vos offres d'emploi : elles seront visibles après validation par notre équipe."
            : 'Votre compte candidat a bien été créé. Complétez votre profil, vos formations et vos expériences pour être visible par les recruteurs.';
    }

    protected function lien(object $notifiable): string
    {
        return route('index', [], false);
    }

    protected function texteBouton(): string
    {
        return 'Se connecter';
    }
}

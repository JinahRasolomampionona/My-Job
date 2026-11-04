<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Base commune de toutes les notifications de l'application.
 *
 * - Envoyée en file d'attente (php artisan queue:work) pour ne pas ralentir les pages.
 * - Enregistrée en base (cloche de notifications) et, si $sendMail, envoyée par email.
 * - Les URL sont stockées en relatif pour fonctionner quel que soit le domaine.
 */
abstract class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** Si le modèle lié a été supprimé avant l'envoi, on abandonne simplement la notification */
    public bool $deleteWhenMissingModels = true;

    protected bool $sendMail = true;

    protected bool $sendDatabase = true;

    abstract protected function titre(): string;

    abstract protected function message(object $notifiable): string;

    /** Chemin relatif vers la page concernée (ex: route('x', $y, false)) */
    abstract protected function lien(object $notifiable): string;

    /** Icône Font Awesome affichée dans la liste des notifications */
    protected function icone(): string
    {
        return 'fa-bell';
    }

    /** Couleur Bootstrap : primary, success, danger, warning, info */
    protected function couleur(): string
    {
        return 'primary';
    }

    protected function texteBouton(): string
    {
        return 'Voir le détail';
    }

    /** Lignes supplémentaires ajoutées uniquement dans l'email */
    protected function lignesEmail(object $notifiable): array
    {
        return [];
    }

    public function via(object $notifiable): array
    {
        return array_values(array_filter([
            $this->sendDatabase ? 'database' : null,
            $this->sendMail ? 'mail' : null,
        ]));
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject($this->titre().' | '.config('app.name'))
            ->greeting('Bonjour '.$notifiable->name.',')
            ->line($this->message($notifiable));

        foreach ($this->lignesEmail($notifiable) as $ligne) {
            $mail->line($ligne);
        }

        return $mail
            ->action($this->texteBouton(), url($this->lien($notifiable)))
            ->salutation("Cordialement,\nL'équipe ".config('app.name'));
    }

    /**
     * Données enregistrées dans la table notifications.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'titre' => $this->titre(),
            'message' => $this->message($notifiable),
            'url' => $this->lien($notifiable),
            'icone' => $this->icone(),
            'couleur' => $this->couleur(),
        ];
    }
}

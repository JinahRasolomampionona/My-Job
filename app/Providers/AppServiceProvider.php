<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Offers;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Dates relatives en français ("il y a 5 minutes")
        Carbon::setLocale('fr');

        // Données du footer public (et des suggestions de l'accueil) : domaines qui recrutent
        // et nombre d'offres, mis en cache 10 min
        View::composer(['Layout.layout', 'index'], function ($view) {
            $data = Cache::remember('footer.offres', now()->addMinutes(10), fn () => [
                'domaines' => Offers::validees()
                    ->whereNotNull('domaine')
                    ->where('domaine', '!=', '')
                    ->selectRaw('domaine, count(*) as total')
                    ->groupBy('domaine')
                    ->orderByDesc('total')
                    ->take(6)
                    ->get()
                    ->map(fn ($row) => ['nom' => $row->domaine, 'total' => (int) $row->total])
                    ->all(),
                'total' => Offers::validees()->count(),
            ]);

            $view->with('footerDomaines', $data['domaines'])
                ->with('footerTotalOffres', $data['total']);
        });

        // Email de réinitialisation du mot de passe en français
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Réinitialisation de votre mot de passe | '.config('app.name'))
                ->greeting('Bonjour '.$notifiable->name.',')
                ->line('Vous recevez cet email car une demande de réinitialisation de mot de passe a été faite pour votre compte.')
                ->action('Réinitialiser le mot de passe', $url)
                ->line('Ce lien expirera dans '.config('auth.passwords.users.expire').' minutes.')
                ->line("Si vous n'êtes pas à l'origine de cette demande, ignorez simplement cet email.")
                ->salutation("Cordialement,\nL'équipe ".config('app.name'));
        });
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Offers;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Recherche globale des barres du haut (Admin / Recruteur / Candidat) :
 * parcourt toutes les rubriques de la navigation de l'espace connecté
 * et renvoie les résultats regroupés par rubrique.
 */
class GlobalSearchController extends Controller
{
    /** Nombre de résultats affichés par rubrique */
    private const LIMIT = 5;

    public function index(Request $request)
    {
        $request->validate(['q' => 'nullable|string|max:100']);

        $user = $request->user();
        $q = $request->string('q')->trim()->value();

        $groupes = match (true) {
            $q === '' => [],
            $user->hasRole('admin') => $this->admin($q),
            $user->hasRole('recruteur') => $this->recruteur($q, $user),
            default => $this->candidat($q, $user),
        };
        $groupes[] = $this->notifications($q, $user);

        $groupes = array_values(array_filter($groupes, fn ($groupe) => $groupe && $groupe['total'] > 0));

        return view('search.global', [
            'layout' => match (true) {
                $user->hasRole('admin') => 'Layout.admin',
                $user->hasRole('recruteur') => 'Layout.recruiter',
                default => 'Layout.candidate',
            },
            'q' => $q,
            'groupes' => $groupes,
            'total' => array_sum(array_column($groupes, 'total')),
        ]);
    }

    /* ------------------------------------------------------------------ */
    /*  Rubriques par rôle                                                */
    /* ------------------------------------------------------------------ */

    private function admin(string $q): array
    {
        $offres = $this->filtrerOffres(Offers::query(), $q)
            ->orderByRaw('status = ? desc', [Offers::STATUS_EN_ATTENTE])
            ->latest();

        $profils = User::role('candidat')
            ->whereHas('profil', fn ($p) => $this->filtrerProfil($p, $q))
            ->with('profil')
            ->orderByRaw('status = ? desc', [User::STATUS_EN_ATTENTE])
            ->latest();

        $recruteurs = $this->filtrerUtilisateurs(User::where('role', 'recruteur'), $q)->latest();

        $candidats = $this->filtrerUtilisateurs(User::where('role', 'candidat'), $q)
            ->with('profil')
            ->latest();

        return [
            $this->groupe('Offres', 'fa-luggage-cart', $offres, route('admin.offers.index', ['titre' => $q]),
                fn (Offers $o) => $this->itemOffre($o, route('admin.offers.show', $o), true)),
            $this->groupe('Validation des profils', 'fa-user-check', $profils, route('admin.profils.index'),
                fn (User $u) => [
                    'titre' => trim("{$u->profil->prenom} {$u->profil->nom}") ?: $u->name,
                    'sous_titre' => "{$u->profil->poste} · {$u->email}",
                    'url' => route('admin.profils.show', $u),
                    'badge' => $this->badgeStatut($u->status),
                ]),
            $this->groupe('Recruteurs', 'fa-user-tie', $recruteurs, route('admin.recruiters'),
                fn (User $u) => [
                    'titre' => $u->name,
                    'sous_titre' => $u->email,
                    'url' => route('admin.recruiters'),
                ]),
            $this->groupe('Candidats', 'fa-users', $candidats, route('admin.candidates'),
                fn (User $u) => [
                    'titre' => $u->name,
                    'sous_titre' => collect([$u->profil?->poste, $u->email])->filter()->implode(' · '),
                    'url' => $u->profil ? route('admin.profils.show', $u) : route('admin.candidates'),
                ]),
        ];
    }

    private function recruteur(string $q, User $user): array
    {
        $offres = $this->filtrerOffres($user->offers()->getQuery(), $q)->withCount('candidatures')->latest();

        $candidatures = Candidature::query()
            ->whereHas('offre', fn ($o) => $o->where('user_id', $user->id))
            ->where(fn ($c) => $c
                ->whereHas('user', fn ($u) => $this->filtrerUtilisateurs($u, $q, false))
                ->orWhereHas('user.profil', fn ($p) => $this->filtrerProfil($p, $q))
                ->orWhereHas('offre', fn ($o) => $o->where('titre', 'like', "%{$q}%"))
                ->orWhere('message', 'like', "%{$q}%"))
            ->with(['user.profil', 'offre'])
            ->latest();

        $profils = User::role('candidat')
            ->where('status', User::STATUS_VALIDEE)
            ->whereHas('profil', fn ($p) => $this->filtrerProfil($p, $q))
            ->with('profil')
            ->latest();

        return [
            $this->groupe('Mes offres', 'fa-layer-group', $offres, route('recruiters.offers.index'),
                fn (Offers $o) => $this->itemOffre($o, route('recruiters.offers.show', $o), true)
                    + ['extra' => $o->candidatures_count.' candidature(s)']),
            $this->groupe('Candidatures reçues', 'fa-inbox', $candidatures, route('recruiters.offers.index'),
                fn (Candidature $c) => [
                    'titre' => $c->user?->profil
                        ? trim("{$c->user->profil->prenom} {$c->user->profil->nom}")
                        : ($c->user?->name ?? 'Compte supprimé'),
                    'sous_titre' => 'A postulé à « '.($c->offre?->titre ?? '—').' »',
                    'url' => $c->user ? route('recruiters.profils.show', $c->user) : route('recruiters.offers.index'),
                    'extra' => $c->created_at?->diffForHumans(),
                ]),
            $this->groupe('Profils candidats', 'fa-users', $profils, route('recruiters.profils.index', ['search' => $q]),
                fn (User $u) => [
                    'titre' => trim("{$u->profil->prenom} {$u->profil->nom}") ?: $u->name,
                    'sous_titre' => $u->profil->poste,
                    'url' => route('recruiters.profils.show', $u),
                ]),
        ];
    }

    private function candidat(string $q, User $user): array
    {
        $offres = $this->filtrerOffres(Offers::validees(), $q)->orderByDesc('is_urgent')->latest();

        $candidatures = $user->candidatures()->getQuery()
            ->where(fn ($c) => $c
                ->whereHas('offre', fn ($o) => $this->filtrerOffres($o, $q))
                ->orWhere('message', 'like', "%{$q}%"))
            ->with('offre')
            ->latest();

        $formations = $user->formations()->getQuery()
            ->where(fn ($f) => $f
                ->where('diplome', 'like', "%{$q}%")
                ->orWhere('etablissement', 'like', "%{$q}%")
                ->orWhere('anneeScolaire', 'like', "%{$q}%")
                ->orWhere('descriptionFormation', 'like', "%{$q}%"))
            ->latest();

        $experiences = $user->experiences()->getQuery()
            ->where(fn ($e) => $e
                ->where('posteExperience', 'like', "%{$q}%")
                ->orWhere('societe', 'like', "%{$q}%")
                ->orWhere('descriptionExperience', 'like', "%{$q}%"))
            ->latest();

        return [
            $this->groupe("Offres d'emploi", 'fa-briefcase', $offres, route('candidates.offers.index', ['titre' => $q]),
                fn (Offers $o) => $this->itemOffre($o, route('candidates.offers.show', $o))),
            $this->groupe('Mes candidatures', 'fa-paper-plane', $candidatures, route('candidates.candidatures.index'),
                fn ($c) => [
                    'titre' => $c->offre?->titre ?? 'Offre supprimée',
                    'sous_titre' => $c->offre ? "{$c->offre->entreprise} · {$c->offre->localisation}" : '',
                    'url' => $c->offre ? route('candidates.offers.show', $c->offre) : route('candidates.candidatures.index'),
                    'extra' => 'Postulé '.$c->created_at?->diffForHumans(),
                ]),
            $this->groupe('Mes formations', 'fa-graduation-cap', $formations, route('candidates.formations.index'),
                fn ($f) => [
                    'titre' => $f->diplome,
                    'sous_titre' => "{$f->etablissement} · {$f->anneeScolaire}",
                    'url' => route('candidates.formations.show', $f),
                ]),
            $this->groupe('Mes expériences', 'fa-building', $experiences, route('candidates.experiences.index'),
                fn ($e) => [
                    'titre' => $e->posteExperience,
                    'sous_titre' => "{$e->societe} · {$e->anneeDebut} – {$e->anneeFin}",
                    'url' => route('candidates.experiences.show', $e),
                ]),
        ];
    }

    /**
     * Les notifications sont stockées en JSON (accents échappés) : le filtre se fait en PHP.
     */
    private function notifications(string $q, User $user): ?array
    {
        if ($q === '') {
            return null;
        }

        $resultats = $user->notifications()->latest()->take(200)->get()
            ->filter(fn ($n) => Str::contains(
                ($n->data['titre'] ?? '').' '.($n->data['message'] ?? ''), $q, ignoreCase: true
            ))
            ->values();

        return [
            'titre' => 'Notifications',
            'icone' => 'fa-bell',
            'total' => $resultats->count(),
            'voir_tout' => route('notifications.index'),
            'items' => $resultats->take(self::LIMIT)->map(fn ($n) => [
                'titre' => $n->data['titre'] ?? 'Notification',
                'sous_titre' => $n->data['message'] ?? '',
                'url' => route('notifications.read', $n->id),
                'extra' => $n->created_at->diffForHumans(),
            ])->all(),
        ];
    }

    /* ------------------------------------------------------------------ */
    /*  Outils                                                            */
    /* ------------------------------------------------------------------ */

    private function groupe(string $titre, string $icone, Builder $query, string $voirTout, callable $item): array
    {
        $total = (clone $query)->count();

        return [
            'titre' => $titre,
            'icone' => $icone,
            'total' => $total,
            'voir_tout' => $voirTout,
            'items' => $total ? $query->take(self::LIMIT)->get()->map($item)->all() : [],
        ];
    }

    private function filtrerOffres(Builder $query, string $q): Builder
    {
        return $query->where(fn ($o) => $o
            ->where('titre', 'like', "%{$q}%")
            ->orWhere('entreprise', 'like', "%{$q}%")
            ->orWhere('domaine', 'like', "%{$q}%")
            ->orWhere('contrat', 'like', "%{$q}%")
            ->orWhere('localisation', 'like', "%{$q}%")
            ->orWhere('description', 'like', "%{$q}%"));
    }

    private function filtrerProfil(Builder $query, string $q): Builder
    {
        return $query->where(fn ($p) => $p
            ->where('poste', 'like', "%{$q}%")
            ->orWhere('nom', 'like', "%{$q}%")
            ->orWhere('prenom', 'like', "%{$q}%")
            ->orWhere('descriptionProfil', 'like', "%{$q}%"));
    }

    private function filtrerUtilisateurs(Builder $query, string $q, bool $grouper = true): Builder
    {
        $filtre = fn ($u) => $u->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");

        return $grouper ? $query->where($filtre) : $filtre($query);
    }

    private function itemOffre(Offers $offre, string $url, bool $avecStatut = false): array
    {
        return [
            'titre' => $offre->titre,
            'sous_titre' => "{$offre->entreprise} · {$offre->localisation} · {$offre->contrat}",
            'url' => $url,
            'badge' => $avecStatut ? $this->badgeStatut($offre->status) : ($offre->is_urgent ? ['Urgent', 'bg-danger'] : null),
        ];
    }

    private function badgeStatut(?string $status): array
    {
        return match ($status) {
            'validee' => ['Validé', 'bg-success'],
            'refusee' => ['Refusé', 'bg-danger'],
            default => ['En attente', 'bg-warning text-dark'],
        };
    }
}

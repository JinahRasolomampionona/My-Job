<?php

namespace Tests\Feature;

use App\Models\Offers;
use App\Models\Profil;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Recherches des barres du haut (Admin / Recruteur / Candidat) :
 * la zone [data-live-results] est celle rechargée en direct par app.js.
 */
class DashboardSearchTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $recruteur;
    private User $candidat;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->recruteur = User::factory()->recruteur()->create();
        $this->candidat = User::factory()->candidat()->create();
    }

    private function offre(array $attributes = []): Offers
    {
        return Offers::create(array_merge([
            'titre' => 'Comptable',
            'entreprise' => 'Acme',
            'contrat' => 'CDD',
            'localisation' => 'Antananarivo',
            'domaine' => 'Finance',
            'description' => '<p>Gestion de la comptabilité générale de la société.</p>',
            'status' => Offers::STATUS_VALIDEE,
            'is_urgent' => false,
            'user_id' => $this->recruteur->id,
        ], $attributes));
    }

    private function candidatValide(string $poste, string $description = 'Description du profil'): User
    {
        $user = User::factory()->candidat()->create(['status' => User::STATUS_VALIDEE]);

        $profil = new Profil();
        $profil->user_id = $user->id;
        foreach (['etude', 'experience', 'civilite', 'nom', 'prenom', 'adresse', 'contact'] as $champ) {
            $profil->$champ = 'Valeur';
        }
        $profil->poste = $poste;
        $profil->naissance = '1995-01-01';
        $profil->email = $user->email;
        $profil->descriptionProfil = $description;
        $profil->save();

        return $user;
    }

    public function test_candidate_search_also_matches_the_offer_description(): void
    {
        $this->offre(['titre' => 'Chef de projet', 'description' => '<p>Projet de transformation informatique.</p>']);
        $this->offre(['titre' => 'Comptable senior']);

        $this->actingAs($this->candidat)
            ->get(route('candidates.offers.index', ['titre' => 'informatique']))
            ->assertOk()
            ->assertSee('data-live-results', false)
            ->assertSee('Chef de projet')
            ->assertDontSee('Comptable senior');
    }

    public function test_recruiter_profile_search_matches_poste_and_description(): void
    {
        $this->candidatValide('Développeur web');
        $this->candidatValide('Assistant', 'Passionné par le développeur mobile');
        $this->candidatValide('Comptable');

        $this->actingAs($this->recruteur)
            ->get(route('recruiters.profils.index', ['search' => 'développeur']))
            ->assertOk()
            ->assertSee('data-live-results', false)
            ->assertSee('Développeur web')
            ->assertSee('Assistant')
            ->assertDontSee('Comptable')
            ->assertSee('2 résultat(s)');
    }

    public function test_admin_search_filters_offers_of_every_status(): void
    {
        $this->offre(['titre' => 'Technicien informatique', 'status' => Offers::STATUS_EN_ATTENTE]);
        $this->offre(['titre' => 'Développeur', 'domaine' => 'Informatique', 'status' => Offers::STATUS_REFUSEE]);
        $this->offre(['titre' => 'Caissier']);

        $this->actingAs($this->admin)
            ->get(route('admin.offers.index', ['titre' => 'informatique']))
            ->assertOk()
            ->assertSee('data-live-results', false)
            ->assertSee('Technicien informatique')
            ->assertSee('Développeur')
            ->assertDontSee('Caissier')
            ->assertSee('2 résultat(s)');
    }

    public function test_every_dashboard_search_bar_uses_the_global_search(): void
    {
        foreach ([[$this->admin, 'admin.index'], [$this->recruteur, 'recruiters.recruiter'], [$this->candidat, 'candidates.candidate']] as [$user, $page]) {
            $this->actingAs($user)
                ->get(route($page))
                ->assertOk()
                ->assertSee('action="'.route('dashboard.search').'"', false)
                ->assertDontSee('action="'.route('search.index').'"', false);
        }
    }

    public function test_admin_global_search_covers_offers_users_and_profiles(): void
    {
        $this->offre(['titre' => 'Technicien Rakoto', 'status' => Offers::STATUS_EN_ATTENTE]);
        User::factory()->recruteur()->create(['name' => 'Société Rakoto']);
        $this->candidatValide('Développeur')->update(['name' => 'Jean Rakoto']);

        $this->actingAs($this->admin)
            ->get(route('dashboard.search', ['q' => 'rakoto']))
            ->assertOk()
            ->assertSee('data-live-results', false)
            ->assertSee('Offres')
            ->assertSee('Technicien')
            ->assertSee('Recruteurs')
            ->assertSee('Société')
            ->assertSee('Candidats')
            ->assertSee('Jean');
    }

    public function test_recruiter_global_search_only_shows_their_own_offers(): void
    {
        $autre = User::factory()->recruteur()->create();
        $this->offre(['titre' => 'Analyste data interne']);
        $this->offre(['titre' => 'Analyste data concurrent', 'user_id' => $autre->id]);
        $this->candidatValide('Analyste junior');

        $this->actingAs($this->recruteur)
            ->get(route('dashboard.search', ['q' => 'analyste']))
            ->assertOk()
            ->assertSee('Mes offres')
            ->assertSee('data interne')
            ->assertDontSee('data concurrent')
            ->assertSee('Profils candidats')
            ->assertSee('junior');
    }

    public function test_candidate_global_search_covers_offers_and_their_own_data(): void
    {
        $this->offre(['titre' => 'Marketing digital']);
        $formation = new \App\Models\Formation();
        $formation->user_id = $this->candidat->id;
        $formation->anneeScolaire = '2020';
        $formation->diplome = 'Master Marketing';
        $formation->etablissement = 'ISCAM';
        $formation->descriptionFormation = 'Formation';
        $formation->save();

        $this->actingAs($this->candidat)
            ->get(route('dashboard.search', ['q' => 'marketing']))
            ->assertOk()
            ->assertSee("Offres d'emploi")
            ->assertSee('digital')
            ->assertSee('Mes formations')
            ->assertSee('ISCAM')
            ->assertDontSee('Recruteurs');
    }

    public function test_empty_global_search_shows_a_hint(): void
    {
        $this->actingAs($this->candidat)
            ->get(route('dashboard.search'))
            ->assertOk()
            ->assertSee('Tapez un mot-clé');
    }
}

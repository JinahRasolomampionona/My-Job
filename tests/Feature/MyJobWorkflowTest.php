<?php

namespace Tests\Feature;

use App\Models\Candidature;
use App\Models\Formation;
use App\Models\Offers;
use App\Models\Profil;
use App\Models\User;
use App\Notifications\CandidatureConfirmeeNotification;
use App\Notifications\NouvelleCandidatureNotification;
use App\Notifications\NouvelleOffreNotification;
use App\Notifications\OffreSoumiseNotification;
use App\Notifications\OffreStatutNotification;
use App\Notifications\ProfilSoumisNotification;
use App\Notifications\ProfilStatutNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class MyJobWorkflowTest extends TestCase
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
            'titre' => 'Développeur Laravel',
            'entreprise' => 'Acme',
            'contrat' => 'CDI',
            'localisation' => 'Antananarivo',
            'domaine' => 'Informatique',
            'description' => '<p>Une très belle offre pour un développeur passionné.</p>',
            'status' => Offers::STATUS_VALIDEE,
            'is_urgent' => false,
            'user_id' => $this->recruteur->id,
        ], $attributes));
    }

    private function profil(User $user): Profil
    {
        $profil = new Profil();
        $profil->user_id = $user->id;
        foreach (['poste', 'etude', 'experience', 'civilite', 'nom', 'prenom', 'adresse', 'contact'] as $champ) {
            $profil->$champ = 'Valeur';
        }
        $profil->naissance = '1995-01-01';
        $profil->email = $user->email;
        $profil->descriptionProfil = 'Description du profil';
        $profil->save();

        return $profil;
    }

    /* --- Sécurité des espaces --- */

    public function test_guests_are_sent_to_the_login_modal(): void
    {
        $this->get(route('admin.index'))->assertRedirect(route('login'));
        $this->get(route('recruiters.recruiter'))->assertRedirect(route('login'));
        $this->get(route('candidates.candidate'))->assertRedirect(route('login'));
    }

    public function test_each_role_only_accesses_its_own_space(): void
    {
        $this->actingAs($this->candidat)->get(route('admin.index'))->assertForbidden();
        $this->actingAs($this->candidat)->get(route('recruiters.recruiter'))->assertForbidden();
        $this->actingAs($this->recruteur)->get(route('candidates.candidate'))->assertForbidden();
        $this->actingAs($this->recruteur)->post(route('admin.offre.valider', $this->offre()))->assertForbidden();

        $this->actingAs($this->admin)->get(route('admin.index'))->assertOk();
        $this->actingAs($this->recruteur)->get(route('recruiters.recruiter'))->assertOk();
        $this->actingAs($this->candidat)->get(route('candidates.candidate'))->assertOk();
    }

    public function test_dashboard_redirects_to_the_role_space(): void
    {
        $this->actingAs($this->recruteur)->get(route('dashboard'))->assertRedirect(route('recruiters.recruiter'));
    }

    public function test_a_recruiter_cannot_touch_the_offer_of_another_recruiter(): void
    {
        $autre = User::factory()->recruteur()->create();
        $offre = $this->offre();

        $this->actingAs($autre)->get(route('recruiters.offers.edit', $offre))->assertForbidden();
        $this->actingAs($autre)->post(route('recruiters.offers.destroy', $offre))->assertForbidden();
        $this->assertModelExists($offre);
    }

    public function test_a_candidate_cannot_delete_the_formation_of_another_candidate(): void
    {
        $autre = User::factory()->candidat()->create();
        $formation = new Formation();
        $formation->user_id = $autre->id;
        $formation->anneeScolaire = '2020';
        $formation->diplome = 'Licence';
        $formation->etablissement = 'Université';
        $formation->descriptionFormation = 'Description';
        $formation->save();

        $this->actingAs($this->candidat)
            ->post(route('candidates.formations.destroy', $formation))
            ->assertForbidden();
        $this->assertModelExists($formation);
    }

    public function test_admin_cannot_be_deleted_from_user_lists(): void
    {
        $this->actingAs($this->admin)->delete(route('admin.recruiters.destroy', $this->admin));
        $this->assertModelExists($this->admin);
    }

    /* --- Offres et notifications --- */

    public function test_new_offer_notifies_admins_and_is_sanitized(): void
    {
        Notification::fake();

        $this->actingAs($this->recruteur)->post(route('recruiters.offers.store'), [
            'titre' => 'Développeur Full-Stack (H/F)',
            'entreprise' => "L'Entreprise",
            'contrat' => 'CDI',
            'localisation' => 'Antananarivo',
            'domaine' => 'Informatique',
            'description' => '<p onclick="alert(1)">Super poste avec <strong>avantages</strong></p><script>alert(1)</script>',
            'is_urgent' => '1',
        ])->assertRedirect(route('recruiters.offers.index'));

        $offre = Offers::firstOrFail();
        $this->assertSame(Offers::STATUS_EN_ATTENTE, $offre->status);
        $this->assertTrue($offre->is_urgent);
        $this->assertStringNotContainsString('script', $offre->description);
        $this->assertStringNotContainsString('onclick', $offre->description);
        $this->assertStringContainsString('<strong>avantages</strong>', $offre->description);

        Notification::assertSentTo($this->admin, OffreSoumiseNotification::class);
    }

    public function test_validating_an_offer_notifies_the_recruiter_and_the_candidates(): void
    {
        Notification::fake();
        $offre = $this->offre(['status' => Offers::STATUS_EN_ATTENTE]);

        $this->actingAs($this->admin)->post(route('admin.offre.valider', $offre))->assertRedirect();

        $this->assertSame(Offers::STATUS_VALIDEE, $offre->fresh()->status);
        Notification::assertSentTo($this->recruteur, OffreStatutNotification::class,
            fn ($n, $channels) => in_array('mail', $channels) && in_array('database', $channels));
        Notification::assertSentTo($this->candidat, NouvelleOffreNotification::class,
            fn ($n, $channels) => $channels === ['database']);
    }

    public function test_pending_offers_are_hidden_from_the_public(): void
    {
        $offre = $this->offre(['status' => Offers::STATUS_EN_ATTENTE]);

        $this->get(route('offers.show', $offre->id))->assertNotFound();
        $this->get(route('index'))->assertDontSee('Développeur Laravel');
    }

    public function test_search_finds_validated_offers(): void
    {
        $this->offre();

        $this->get(route('search.index', ['titre' => 'laravel', 'localisation' => 'Antananarivo']))
            ->assertOk()
            ->assertSee('Développeur Laravel');
    }

    /* --- Profils --- */

    public function test_profile_validation_notifies_the_candidate_by_email(): void
    {
        Notification::fake();
        $this->profil($this->candidat);

        $this->actingAs($this->admin)->post(route('admin.profils.valider', $this->candidat))->assertRedirect();

        $this->assertSame(User::STATUS_VALIDEE, $this->candidat->fresh()->status);
        Notification::assertSentTo($this->candidat, ProfilStatutNotification::class,
            fn ($n, $channels) => in_array('mail', $channels));
    }

    public function test_creating_a_profile_notifies_admins_and_does_not_duplicate(): void
    {
        Notification::fake();
        $data = [
            'poste' => 'Développeur', 'etude' => 'Master 2', 'experience' => '3 ans', 'civilite' => 'mme',
            'nom' => 'Rakoto', 'prenom' => 'Hery', 'naissance' => '1995-05-10', 'adresse' => 'Lot II',
            'email' => 'hery@example.com', 'contact' => '+261 34 00 000 00',
            'descriptionProfil' => 'Développeuse passionnée par le web.',
        ];

        $this->actingAs($this->candidat)->post(route('candidates.profils.store'), $data)->assertSessionHasNoErrors();
        $this->actingAs($this->candidat)->post(route('candidates.profils.store'), $data)->assertSessionHasNoErrors();

        $this->assertSame(1, Profil::where('user_id', $this->candidat->id)->count());
        Notification::assertSentTo($this->admin, ProfilSoumisNotification::class);
    }

    public function test_recruiters_only_see_validated_profiles(): void
    {
        $this->profil($this->candidat);

        $this->actingAs($this->recruteur)->get(route('recruiters.profils.show', $this->candidat))->assertNotFound();

        $this->candidat->forceFill(['status' => User::STATUS_VALIDEE])->save();
        $this->actingAs($this->recruteur)->get(route('recruiters.profils.show', $this->candidat))->assertOk();
    }

    /* --- Candidatures --- */

    public function test_a_validated_candidate_can_apply_once_and_everyone_is_notified(): void
    {
        Notification::fake();
        $this->profil($this->candidat);
        $this->candidat->forceFill(['status' => User::STATUS_VALIDEE])->save();
        $offre = $this->offre();

        $this->actingAs($this->candidat)
            ->postJson(route('candidates.offers.apply', $offre), ['message' => 'Je suis motivé'])
            ->assertOk()
            ->assertJsonPath('ok', true);

        $this->actingAs($this->candidat)
            ->postJson(route('candidates.offers.apply', $offre))
            ->assertStatus(422);

        $this->assertSame(1, Candidature::count());
        Notification::assertSentTo($this->recruteur, NouvelleCandidatureNotification::class);
        Notification::assertSentTo($this->candidat, CandidatureConfirmeeNotification::class);

        // Le recruteur voit maintenant le candidat dans le détail de son offre
        $this->actingAs($this->recruteur)->get(route('recruiters.offers.show', $offre))->assertSee('Je suis motivé');
    }

    public function test_a_candidate_without_validated_profile_cannot_apply(): void
    {
        $this->actingAs($this->candidat)
            ->postJson(route('candidates.offers.apply', $this->offre()))
            ->assertStatus(422);

        $this->assertSame(0, Candidature::count());
    }

    /* --- Centre de notifications --- */

    public function test_notification_center_lists_and_marks_notifications_as_read(): void
    {
        $offre = $this->offre();
        $this->recruteur->notify(new OffreStatutNotification($offre));
        $notification = $this->recruteur->notifications()->first();

        $this->actingAs($this->recruteur)->getJson(route('notifications.latest'))
            ->assertOk()
            ->assertJsonPath('unread', 1)
            ->assertJsonPath('items.0.titre', 'Offre validée');

        $this->actingAs($this->recruteur)->get(route('notifications.index'))->assertOk()->assertSee('Offre validée');

        $this->actingAs($this->recruteur)->get(route('notifications.read', $notification->id))
            ->assertRedirect(route('recruiters.offers.show', $offre, false));
        $this->assertNotNull($notification->fresh()->read_at);

        // Un autre utilisateur ne peut pas lire cette notification
        $this->actingAs($this->candidat)->get(route('notifications.read', $notification->id))->assertNotFound();
    }

    public function test_every_page_renders_without_error(): void
    {
        $this->profil($this->candidat);
        $this->candidat->forceFill(['status' => User::STATUS_VALIDEE])->save();
        $offre = $this->offre(['is_urgent' => true]);
        Candidature::create(['user_id' => $this->candidat->id, 'offer_id' => $offre->id, 'message' => 'Bonjour']);
        $this->candidat->notify(new ProfilStatutNotification(User::STATUS_VALIDEE));
        $this->recruteur->notify(new NouvelleCandidatureNotification(Candidature::first()));

        $pages = [
            [null, ['index', 'offers.index', ['offers.show', $offre->id], ['search.index', ['titre' => 'dev']]]],
            [$this->admin, ['admin.index', 'admin.recruiters', 'admin.candidates', 'admin.offers.index',
                ['admin.offers.show', $offre], 'admin.profils.index', ['admin.profils.show', $this->candidat],
                'notifications.index', 'offers.create', ['offers.edit', $offre->id]]],
            [$this->recruteur, ['recruiters.recruiter', 'recruiters.offers.index', ['recruiters.offers.show', $offre],
                'recruiters.offers.create', ['recruiters.offers.edit', $offre], 'recruiters.profils.index',
                ['recruiters.profils.show', $this->candidat], 'notifications.index', 'index']],
            [$this->candidat, ['candidates.candidate', 'candidates.offers.index', ['candidates.offers.show', $offre],
                'candidates.profils.profil', 'candidates.candidatures.index', 'notifications.index', ['offers.show', $offre->id]]],
        ];

        foreach ($pages as [$user, $routes]) {
            foreach ($routes as $route) {
                [$name, $params] = is_array($route) ? $route : [$route, []];
                $request = $user ? $this->actingAs($user) : $this;
                $request->get(route($name, $params))->assertOk();
            }
            auth()->logout();
        }
    }

    public function test_notification_emails_render(): void
    {
        $offre = $this->offre();
        $mail = (new OffreStatutNotification($offre))->toMail($this->recruteur);

        $this->assertStringContainsString('Offre validée', $mail->subject);
        $this->assertStringContainsString('Bonjour', (string) $mail->render());
    }
}

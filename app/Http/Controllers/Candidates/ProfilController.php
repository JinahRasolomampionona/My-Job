<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfilesFormRequest;
use App\Models\Profil;
use App\Models\User;
use App\Notifications\ProfilSoumisNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ProfilController extends Controller
{
    /**
     * Page "Mon profil" : profil, formations et expériences du candidat connecté.
     */
    public function index()
    {
        $user = Auth::user()->load('profil', 'formations', 'experiences');
        return view('candidates.profils.profil', ['user' => $user]);
    }

    public function create()
    {
        return redirect()->route('candidates.profils.profil');
    }

    /**
     * Création du profil. Un candidat n'a qu'un seul profil : s'il existe déjà, il est mis à jour.
     */
    public function store(ProfilesFormRequest $request)
    {
        $user = $request->user();
        $profil = $user->profil()->first();
        $modification = $profil !== null;

        $profil ??= new Profil();
        $profil->user_id = $user->id;
        $this->remplir($profil, $request);
        $profil->save();

        $this->soumettreValidation($user, $modification);

        return redirect()->route('candidates.profils.profil')
            ->with('success', "Profil enregistré. Il sera visible par les recruteurs après validation par l'administrateur.");
    }

    public function show(User $user)
    {
        // Un candidat ne peut consulter que son propre profil
        abort_unless($user->id === Auth::id(), 403);

        return redirect()->route('candidates.profils.profil');
    }

    public function edit(Profil $profil)
    {
        $this->verifierProprietaire($profil);

        return redirect()->route('candidates.profils.profil');
    }

    public function update(ProfilesFormRequest $request, Profil $profil)
    {
        $this->verifierProprietaire($profil);

        $this->remplir($profil, $request);
        $profil->save();

        $this->soumettreValidation($request->user(), true);

        return redirect()->route('candidates.profils.profil')
            ->with('success', 'Profil mis à jour. Il sera de nouveau examiné par l\'administrateur.');
    }

    public function destroy(Profil $profil)
    {
        $this->verifierProprietaire($profil);

        $profil->delete();

        $user = Auth::user();
        $user->status = User::STATUS_EN_ATTENTE;
        $user->save();

        return redirect()->route('candidates.profils.profil')->with('success', 'Profil supprimé.');
    }

    private function remplir(Profil $profil, ProfilesFormRequest $request): void
    {
        $profil->poste = $request->input('poste');
        $profil->etude = $request->input('etude');
        $profil->experience = $request->input('experience');
        $profil->civilite = $request->input('civilite');
        $profil->nom = $request->input('nom');
        $profil->prenom = $request->input('prenom');
        $profil->naissance = $request->input('naissance');
        $profil->adresse = $request->input('adresse');
        $profil->email = $request->input('email');
        $profil->contact = $request->input('contact');
        $profil->descriptionProfil = $request->input('descriptionProfil');
    }

    /**
     * Le profil repasse "en attente" et les administrateurs sont notifiés.
     */
    private function soumettreValidation(User $user, bool $modification): void
    {
        $user->status = User::STATUS_EN_ATTENTE;
        $user->save();

        Notification::send(User::role('admin')->get(), new ProfilSoumisNotification($user, $modification));
    }

    private function verifierProprietaire(Profil $profil): void
    {
        abort_unless((int) $profil->user_id === (int) Auth::id(), 403);
    }
}

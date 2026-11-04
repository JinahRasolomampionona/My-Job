<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExperienceFormRequest;
use App\Models\Experience;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    /**
     * Les expériences sont affichées sur la page "Mon profil".
     */
    public function index()
    {
        return redirect()->route('candidates.profils.profil');
    }

    public function create()
    {
        return redirect()->route('candidates.profils.profil');
    }

    public function store(ExperienceFormRequest $request)
    {
        $experience = new Experience();
        $experience->user_id = $request->user()->id;
        $this->remplir($experience, $request);
        $experience->save();

        return redirect()->route('candidates.profils.profil')->with('success', 'Expérience ajoutée.');
    }

    public function show(Experience $experience)
    {
        $this->verifierProprietaire($experience);

        return redirect()->route('candidates.profils.profil');
    }

    public function edit(Experience $experience)
    {
        $this->verifierProprietaire($experience);

        return redirect()->route('candidates.profils.profil');
    }

    public function update(ExperienceFormRequest $request, Experience $experience)
    {
        $this->verifierProprietaire($experience);

        $this->remplir($experience, $request);
        $experience->save();

        return redirect()->route('candidates.profils.profil')->with('success', 'Expérience modifiée.');
    }

    public function destroy(Experience $experience)
    {
        $this->verifierProprietaire($experience);

        $experience->delete();
        return redirect()->route('candidates.profils.profil')->with('success', 'Expérience supprimée.');
    }

    private function remplir(Experience $experience, ExperienceFormRequest $request): void
    {
        // Les colonnes sont NOT NULL : les champs facultatifs vides sont enregistrés en chaîne vide
        $experience->moisDebut = $request->input('mois-debut');
        $experience->anneeDebut = $request->input('annee-debut');
        $experience->moisFin = $request->input('mois-fin') ?? '';
        $experience->anneeFin = $request->input('annee-fin') ?? '';
        $experience->anneeExperience = $request->input('anneeExperience') ?? '';
        $experience->societe = $request->input('societe');
        $experience->posteExperience = $request->input('posteExperience');
        $experience->descriptionExperience = $request->input('descriptionExperience') ?? '';
    }

    private function verifierProprietaire(Experience $experience): void
    {
        abort_unless((int) $experience->user_id === (int) Auth::id(), 403);
    }
}

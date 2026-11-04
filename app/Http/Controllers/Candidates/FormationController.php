<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormationFormRequest;
use App\Models\Formation;
use Illuminate\Support\Facades\Auth;

class FormationController extends Controller
{
    /**
     * Les formations sont affichées sur la page "Mon profil".
     */
    public function index()
    {
        return redirect()->route('candidates.profils.profil');
    }

    public function create()
    {
        return redirect()->route('candidates.profils.profil');
    }

    public function store(FormationFormRequest $request)
    {
        $formation = new Formation();
        $formation->user_id = $request->user()->id;
        $this->remplir($formation, $request);
        $formation->save();

        return redirect()->route('candidates.profils.profil')->with('success', 'Formation ajoutée.');
    }

    public function show(Formation $formation)
    {
        $this->verifierProprietaire($formation);

        return redirect()->route('candidates.profils.profil');
    }

    public function edit(Formation $formation)
    {
        $this->verifierProprietaire($formation);

        return redirect()->route('candidates.profils.profil');
    }

    public function update(FormationFormRequest $request, Formation $formation)
    {
        $this->verifierProprietaire($formation);

        $this->remplir($formation, $request);
        $formation->save();

        return redirect()->route('candidates.profils.profil')->with('success', 'Formation modifiée.');
    }

    public function destroy(Formation $formation)
    {
        $this->verifierProprietaire($formation);

        $formation->delete();
        return redirect()->route('candidates.profils.profil')->with('success', 'Formation supprimée.');
    }

    private function remplir(Formation $formation, FormationFormRequest $request): void
    {
        $formation->anneeScolaire = $request->input('annee-scolaire');
        $formation->diplome = $request->input('diplome');
        $formation->etablissement = $request->input('etablissement');
        $formation->descriptionFormation = $request->input('descriptionFormation');
    }

    private function verifierProprietaire(Formation $formation): void
    {
        abort_unless((int) $formation->user_id === (int) Auth::id(), 403);
    }
}

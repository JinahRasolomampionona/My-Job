<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormationFormRequest;
use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $formations = Formation::all();
        return view('candidates.profils.profil', ['formationsView' => $formations]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('candidates.formations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormationFormRequest $request)
    {
        //
        $formation = new Formation();
        $formation->user_id = $request->user()->id;
        $formation->anneeScolaire = $request->input('annee-scolaire');
        $formation->diplome = $request->input('diplome');
        $formation->etablissement = $request->input('etablissement');
        $formation->descriptionFormation = $request->input('descriptionFormation');
        $formation->save();
        // Mail::to($request->user())->send(new GmailEmail);
        return redirect()->route('candidates.profils.profil');
    }

    /**
     * Display the specified resource.
     */
    public function show(Formation $formation)
    {
        return view('candidates.formations.show', ['formation' => $formation]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Formation $formation)
    {
        //
        return view('candidates.formations.edit', ['formation' => $formation]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormationFormRequest $request, Formation $formation)
    {
        
        $formation->anneeScolaire = $request->input('annee-scolaire');
        $formation->diplome = $request->input('diplome');
        $formation->etablissement = $request->input('etablissement');
        $formation->descriptionFormation = $request->input('descriptionFormation');
        $formation->save();
        return redirect()->route('candidates.profils.profil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Formation $formation)
    {
        //
        $formation ->delete();
        return redirect()->route('candidates.profils.profil');
    }
}

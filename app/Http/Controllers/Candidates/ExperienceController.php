<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExperienceFormRequest;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $experiences = Experience::all();
        return view('candidates.profils.profil', ['experiencesView' => $experiences]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('candidates.experiences.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExperienceFormRequest $request)
    {
        //
        $experience = new Experience();
        $experience->user_id = $request->user()->id;
        $experience->moisDebut = $request->input('mois-debut');
        $experience->anneeDebut = $request->input('annee-debut');
        $experience->moisFin = $request->input('mois-fin');
        $experience->anneeFin = $request->input('annee-fin');
        $experience->anneeExperience = $request->input('anneeExperience');
        $experience->societe = $request->input('societe');
        $experience->posteExperience = $request->input('posteExperience');
        $experience->descriptionExperience = $request->input('descriptionExperience');
        $experience->save();
        // Mail::to($request->user())->send(new GmailEmail);
        return redirect()->route('candidates.profils.profil');
    }

    /**
     * Display the specified resource.
     */
    public function show(Experience $experience)
    {
        return view('candidates.experiences.show', ['experience' => $experience]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Experience $experience)
    {
        //
        return view('candidates.experiences.edit', ['experience' => $experience]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExperienceFormRequest $request, Experience $experience)
    {
        
        $experience->moisDebut = $request->input('mois-debut');
        $experience->anneeDebut = $request->input('annee-debut');
        $experience->moisFin = $request->input('mois-fin');
        $experience->anneeFin = $request->input('annee-fin');
        $experience->anneeExperience = $request->input('anneeExperience');
        $experience->societe = $request->input('societe');
        $experience->posteExperience = $request->input('posteExperience');
        $experience->descriptionExperience = $request->input('descriptionExperience');
        $experience->save();
        return redirect()->route('candidates.profils.profil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experience $experience)
    {
        //
        $experience ->delete();
        return redirect()->route('candidates.profils.profil');
    }
}

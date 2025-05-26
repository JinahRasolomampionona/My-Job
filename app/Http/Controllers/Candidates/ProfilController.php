<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfilesFormRequest;
use App\Models\Profil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return view('candidates.profils.profil', ['user'=>$user]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('candidates.profils.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfilesFormRequest $request)
    {
        //
        $profil = new Profil();
        $profil->user_id = $request->user()->id;
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
        $profil->save();
        // Mail::to($request->user())->send(new GmailEmail);
        return redirect()->route('candidates.profils.profil');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('candidates.profils.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profil $profil)
    {
        //
        return view('candidates.profils.edit', ['profil' => $profil]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfilesFormRequest $request, Profil $profil)
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
        $profil->save();
        return redirect()->route('candidates.profils.profil');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profil $profil)
    {
        //
        $profil->delete();
        return redirect()->route('candidates.profils.profil');
    }
}

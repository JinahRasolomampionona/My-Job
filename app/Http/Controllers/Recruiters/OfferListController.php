<?php

namespace App\Http\Controllers\Recruiters;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfferFormRequest;
use App\Models\Offers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferListController extends Controller
{
    public function index()
    {
        $offre = Offers::where('user_id', Auth::id())->get();
        return view('recruiters.offers.index', ['offresView' => $offre]);
    }

    public function create()
    {
        return view('recruiters.offers.create');
    }

    public function store(OfferFormRequest $request)
    {

        // Enregistrement de l’offre
        $offres = new Offers();
        $offres->titre = $request->input('titre');
        $offres->entreprise = $request->input('entreprise');
        $offres->contrat = $request->input('contrat');
        $offres->localisation = $request->input('localisation');
        $offres->domaine = $request->input('domaine');
        $offres->description = $request->input('description');
        $offres->status = 'en attente';
        $offres->user_id = Auth::id();
        $offres->save();

       

        return redirect()->route('recruiters.offers.index');
    }

    public function show(Offers $offre)
    {
        return view('recruiters.offers.show', ['offre' => $offre]);
    }

    public function edit(Offers $offre)
    {
        return view('recruiters.offers.edit', ['offre' => $offre]);
    }

    public function update(OfferFormRequest $request, Offers $offre)
    {

        // Mise à jour de l’offre
        $offres = new Offers();
        $offres->titre = $request->input('titre');
        $offres->entreprise = $request->input('entreprise');
        $offres->contrat = $request->input('contrat');
        $offres->localisation = $request->input('localisation');
        $offres->domaine = $request->input('domaine');
        $offres->description = $request->input('description');
        $offre->save();

        return redirect()->route('recruiters.offers.index');
    }

    public function destroy(Offers $offre)
    {
        $offre->delete();
        return redirect()->route('recruiters.offers.index');
    }
}

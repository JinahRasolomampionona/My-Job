<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\Controller;
use App\Models\Offers;
use Illuminate\Http\Request;

class OfferViewController extends Controller
{
    /**
     * Liste des offres validées, les urgentes en premier.
     */
    public function index(Request $request)
    {
        $titre = $request->string('titre')->trim()->value();
        $localisation = $request->string('localisation')->trim()->value();

        $offres = Offers::validees()
            ->when($titre, fn ($q) => $q->where(fn ($q) => $q
                ->where('titre', 'like', "%{$titre}%")
                ->orWhere('entreprise', 'like', "%{$titre}%")
                ->orWhere('domaine', 'like', "%{$titre}%")
                ->orWhere('contrat', 'like', "%{$titre}%")
                ->orWhere('description', 'like', "%{$titre}%")))
            ->when($localisation, fn ($q) => $q->where('localisation', 'like', "%{$localisation}%"))
            ->orderByDesc('is_urgent')
            ->latest()
            ->get();
        return view('candidates.offers.index', ['offresView' => $offres]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Offers $offre)
    {
        abort_unless($offre->isValidee(), 404);

        return view('candidates.offers.show', [
            'offresView' => $offre,
            'dejaPostule' => $request->user()->candidatures()->where('offer_id', $offre->id)->exists(),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Offers;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Recherche d'offres validées par titre/entreprise et localisation.
     */
    public function index(Request $request)
    {
        $input = $request->validate([
            'titre' => 'nullable|string|max:100',
            'localisation' => 'nullable|string|max:100',
        ]);

        $titre = $input['titre'] ?? null;
        $localisation = $input['localisation'] ?? null;

        $offres = Offers::validees()
            ->when($localisation, function ($query) use ($localisation) {
                $query->where('localisation', 'like', "%{$localisation}%");
            })
            ->when($titre, function ($query) use ($titre) {
                $query->where(function ($query) use ($titre) {
                    $query->where('titre', 'like', "%{$titre}%")
                        ->orWhere('entreprise', 'like', "%{$titre}%")
                        ->orWhere('domaine', 'like', "%{$titre}%");
                });
            })
            ->orderByDesc('is_urgent')
            ->latest()
            ->get();

        return view('search.index', ['offres' => $offres, 'input' => $input]);
    }
}

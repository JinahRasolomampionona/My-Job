<?php

namespace App\Http\Controllers;

use App\Models\Offers;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Page d'accueil : offres validées (filtrées par la recherche du hero),
     * les urgentes en premier, paginées par 6, et les 4 plus récentes
     * pour le bloc "Publiées récemment".
     * En AJAX, seule la section des offres est renvoyée.
     */
    public function home(Request $request)
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
                        ->orWhere('domaine', 'like', "%{$titre}%")
                        ->orWhere('contrat', 'like', "%{$titre}%")
                        ->orWhere('description', 'like', "%{$titre}%");
                });
            })
            ->orderByDesc('is_urgent')
            ->latest()
            ->paginate(6)
            ->withQueryString()
            ->fragment('offres');

        $data = [
            'offresView' => $offres,
            'input' => $input,
            'isSearch' => filled($titre) || filled($localisation),
        ];

        if ($request->ajax()) {
            return view('home._offres', $data);
        }

        return view('index', $data + [
            'dernieresOffres' => Offers::validees()->latest()->take(4)->get(),
            'totalOffres' => Offers::validees()->count(),
        ]);
    }
}

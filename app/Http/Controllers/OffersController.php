<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferFormRequest;
use App\Models\Offers;
use App\Support\HtmlSanitizer;
use Illuminate\Support\Facades\Auth;

class OffersController extends Controller
{
    /**
     * Liste publique : uniquement les offres validées.
     */
    public function index()
    {
        $offres = Offers::validees()->orderByDesc('is_urgent')->latest()->get();
        return view('offers.index', ['offresView' => $offres]);
    }

    /**
     * Détail public d'une offre validée.
     */
    public function show(string $id)
    {
        $offres = Offers::validees()->findOrFail($id);
        return view('offers.show', ['offresView' => $offres]);
    }

    // --- Les méthodes ci-dessous sont réservées à l'administrateur (voir routes/web.php) ---

    public function create()
    {
        return view('offers.create');
    }

    public function store(OfferFormRequest $request)
    {
        $offres = new Offers();
        $this->remplir($offres, $request);
        $offres->user_id = Auth::id();
        // Créée par l'administrateur : publiée directement
        $offres->status = Offers::STATUS_VALIDEE;
        $offres->save();

        return redirect()->route('offers.index')->with('success', 'Offre créée.');
    }

    public function edit(string $id)
    {
        $offres = Offers::findOrFail($id);
        return view('offers.edit', ['offresView' => $offres]);
    }

    public function update(OfferFormRequest $request, string $id)
    {
        $offres = Offers::findOrFail($id);
        $this->remplir($offres, $request);
        $offres->save();

        return redirect()->route('offers.index')->with('success', 'Offre modifiée.');
    }

    public function destroy(string $id)
    {
        Offers::findOrFail($id)->delete();

        return redirect()->route('offers.index')->with('success', 'Offre supprimée.');
    }

    private function remplir(Offers $offre, OfferFormRequest $request): void
    {
        $offre->titre = $request->input('titre');
        $offre->entreprise = $request->input('entreprise');
        $offre->contrat = $request->input('contrat');
        $offre->localisation = $request->input('localisation');
        $offre->domaine = $request->input('domaine');
        $offre->description = HtmlSanitizer::clean($request->input('description'));
        $offre->is_urgent = $request->boolean('is_urgent');
    }
}

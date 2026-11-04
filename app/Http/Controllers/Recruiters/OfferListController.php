<?php

namespace App\Http\Controllers\Recruiters;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfferFormRequest;
use App\Models\Offers;
use App\Models\User;
use App\Notifications\OffreSoumiseNotification;
use App\Support\HtmlSanitizer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class OfferListController extends Controller
{
    public function index()
    {
        $offre = Offers::where('user_id', Auth::id())->withCount('candidatures')->latest()->get();
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
        $this->remplir($offres, $request);
        $offres->status = Offers::STATUS_EN_ATTENTE;
        $offres->user_id = Auth::id();
        $offres->save();

        // Email + notification aux administrateurs pour validation
        Notification::send(User::role('admin')->get(), new OffreSoumiseNotification($offres));

        return redirect()->route('recruiters.offers.index')
            ->with('success', "Offre créée, en attente de validation par l'administrateur.");
    }

    public function show(Offers $offre)
    {
        $this->verifierProprietaire($offre);

        $offre->load('candidatures.user.profil');

        return view('recruiters.offers.show', ['offre' => $offre]);
    }

    public function edit(Offers $offre)
    {
        $this->verifierProprietaire($offre);

        return view('recruiters.offers.edit', ['offre' => $offre]);
    }

    public function update(OfferFormRequest $request, Offers $offre)
    {
        $this->verifierProprietaire($offre);

        // Mise à jour de l’offre : elle doit être revalidée par l'administrateur
        $this->remplir($offre, $request);
        $offre->status = Offers::STATUS_EN_ATTENTE;
        $offre->save();

        Notification::send(User::role('admin')->get(), new OffreSoumiseNotification($offre, true));

        return redirect()->route('recruiters.offers.index')
            ->with('success', 'Offre modifiée, elle sera de nouveau visible après validation.');
    }

    public function destroy(Offers $offre)
    {
        $this->verifierProprietaire($offre);

        $offre->delete();
        return redirect()->route('recruiters.offers.index')->with('success', 'Offre supprimée.');
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

    /** Un recruteur ne peut gérer que ses propres offres */
    private function verifierProprietaire(Offers $offre): void
    {
        abort_unless((int) $offre->user_id === (int) Auth::id(), 403);
    }
}

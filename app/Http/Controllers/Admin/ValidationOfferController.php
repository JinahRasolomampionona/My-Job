<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offers;
use App\Models\User;
use App\Notifications\NouvelleOffreNotification;
use App\Notifications\OffreStatutNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ValidationOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $titre = $request->string('titre')->trim()->value();

        // Les offres en attente d'abord, puis les plus récentes
        $offre = Offers::query()
            ->when($titre, fn ($q) => $q->where(fn ($q) => $q
                ->where('titre', 'like', "%{$titre}%")
                ->orWhere('entreprise', 'like', "%{$titre}%")
                ->orWhere('domaine', 'like', "%{$titre}%")
                ->orWhere('contrat', 'like', "%{$titre}%")
                ->orWhere('localisation', 'like', "%{$titre}%")
                ->orWhere('description', 'like', "%{$titre}%")))
            ->orderByRaw("status = ? desc", [Offers::STATUS_EN_ATTENTE])
            ->latest()
            ->get();
        return view('admin.offers.index', ['offresView' => $offre, 'titre' => $titre]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Offers $offre)
    {
        return view('admin.offers.show', ['offresView' => $offre]);
    }

    public function valider(Offers $offre)
    {
        $offre->status = Offers::STATUS_VALIDEE;
        $offre->save();

        // Email + notification au recruteur, notification aux candidats
        $offre->user?->notify(new OffreStatutNotification($offre));
        Notification::send(User::role('candidat')->get(), new NouvelleOffreNotification($offre));

        return redirect()->back()->with('success', 'Offre validée. Le recruteur a été notifié par email.');
    }

    public function refuser(Offers $offre)
    {
        $offre->status = Offers::STATUS_REFUSEE;
        $offre->save();

        $offre->user?->notify(new OffreStatutNotification($offre));

        return redirect()->back()->with('success', 'Offre refusée. Le recruteur a été notifié par email.');
    }
}

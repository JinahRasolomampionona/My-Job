<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use App\Models\Offers;
use App\Models\User;
use App\Notifications\CandidatureConfirmeeNotification;
use App\Notifications\NouvelleCandidatureNotification;
use Illuminate\Http\Request;

class CandidatureController extends Controller
{
    /**
     * Liste des offres auxquelles le candidat a postulé.
     */
    public function index(Request $request)
    {
        $candidatures = $request->user()->candidatures()->with('offre')->latest()->get();

        return view('candidates.candidatures.index', ['candidatures' => $candidatures]);
    }

    /**
     * Le candidat postule à une offre : on enregistre la candidature puis on
     * envoie un email + une notification au recruteur et au candidat.
     */
    public function store(Request $request, Offers $offre)
    {
        abort_unless($offre->isValidee(), 404);

        $user = $request->user();

        $request->validate([
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        if (! $user->profil) {
            return $this->reponse($request, false, 'Veuillez d\'abord créer votre profil avant de postuler.', 422);
        }

        if ($user->status !== User::STATUS_VALIDEE) {
            return $this->reponse($request, false, 'Votre profil doit être validé par l\'administrateur avant de postuler.', 422);
        }

        if ($user->candidatures()->where('offer_id', $offre->id)->exists()) {
            return $this->reponse($request, false, 'Vous avez déjà postulé à cette offre.', 422);
        }

        $candidature = Candidature::create([
            'user_id' => $user->id,
            'offer_id' => $offre->id,
            'message' => $request->input('message'),
        ]);

        $offre->user?->notify(new NouvelleCandidatureNotification($candidature));
        $user->notify(new CandidatureConfirmeeNotification($candidature));

        return $this->reponse($request, true, 'Votre candidature a bien été envoyée ! Un email de confirmation vous a été adressé.');
    }

    private function reponse(Request $request, bool $ok, string $message, int $status = 200)
    {
        if ($request->expectsJson()) {
            return response()->json(['ok' => $ok, 'message' => $message], $status);
        }

        return back()->with($ok ? 'success' : 'error', $message);
    }
}

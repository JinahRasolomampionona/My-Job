<?php

namespace App\Http\Controllers\Recruiters;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilViewController extends Controller
{
    /**
     * Liste des candidats dont le profil a été validé par l'administrateur.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $candidats = User::role('candidat')
            ->where('status', User::STATUS_VALIDEE)
            ->whereHas('profil', function ($subquery) use ($search) {
                if ($search) {
                    $subquery->where(fn ($q) => $q
                        ->where('poste', 'like', "%{$search}%")
                        ->orWhere('nom', 'like', "%{$search}%")
                        ->orWhere('prenom', 'like', "%{$search}%")
                        ->orWhere('descriptionProfil', 'like', "%{$search}%"));
                }
            })
            ->with('profil')
            ->get();

        return view('recruiters.profils.index', ['candidats' => $candidats, 'search' => $search]);
    }

    /**
     * Un recruteur peut voir un profil validé, ou celui d'un candidat ayant postulé à ses offres.
     */
    public function show(Request $request, User $user)
    {
        $aPostule = $user->candidatures()
            ->whereHas('offre', fn ($q) => $q->where('user_id', $request->user()->id))
            ->exists();

        abort_unless(
            $user->hasRole('candidat') && ($user->status === User::STATUS_VALIDEE || $aPostule),
            404
        );

        return view('recruiters.profils.show', ['user' => $user]);
    }
}

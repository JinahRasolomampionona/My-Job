<?php

namespace App\Http\Controllers\Recruiters;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use App\Models\Offers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RecruiterPageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalOffres = Offers::where('user_id', $user->id)->count();
        $totalProfils = User::role('candidat')->where('status', User::STATUS_VALIDEE)->whereHas('profil')->count();
        $totalCandidatures = Candidature::whereHas('offre', fn ($q) => $q->where('user_id', $user->id))->count();
        $totalNotifications = $user->unreadNotifications()->count();

        return view('recruiters.recruiter', compact('totalOffres', 'totalProfils', 'totalCandidatures', 'totalNotifications'));
    }
}

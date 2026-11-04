<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\Controller;
use App\Models\Offers;
use Illuminate\Support\Facades\Auth;

class CandidatePageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalOffres = Offers::validees()->count();
        $totalCandidatures = $user->candidatures()->count();
        $totalNotifications = $user->unreadNotifications()->count();
        $statutProfil = $user->profil ? $user->status : null;

        return view('candidates.candidate', compact('totalOffres', 'totalCandidatures', 'totalNotifications', 'statutProfil'));
    }
}

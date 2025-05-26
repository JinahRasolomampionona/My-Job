<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\Controller;
use App\Models\Offers;
use App\Models\Profil;
use Illuminate\Http\Request;

class CandidatePageController extends Controller
{
    public function index() {
        $totalOffres = Offers::count();
        $totalProfils = Profil::count();

        return view('candidates.candidate', compact('totalOffres', 'totalProfils'));
    }
}

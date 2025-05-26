<?php

namespace App\Http\Controllers\Recruiters;

use App\Http\Controllers\Controller;
use App\Models\Offers;
use App\Models\Profil;
use Illuminate\Http\Request;

class RecruiterPageController extends Controller
{
    public function index() {
        
        $totalOffres = Offers::count();
        $totalProfils = Profil::count();

        return view('recruiters.recruiter', compact('totalOffres', 'totalProfils'));
    }
}

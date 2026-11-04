<?php

namespace App\Http\Controllers;

use App\Models\Offers;
use App\Models\Profil;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalRecruteurs = User::where('role', 'recruteur')->count();
        $totalCandidats = User::where('role', 'candidat')->count();
        $totalOffres = Offers::count();
        $totalProfils = Profil::count();
        $offresEnAttente = Offers::where('status', Offers::STATUS_EN_ATTENTE)->count();
        $profilsEnAttente = User::role('candidat')->whereHas('profil')
            ->where('status', User::STATUS_EN_ATTENTE)->count();

        return view('admin.index', compact(
            'totalRecruteurs', 'totalCandidats', 'totalOffres', 'totalProfils',
            'offresEnAttente', 'profilsEnAttente'
        ));
    }
}

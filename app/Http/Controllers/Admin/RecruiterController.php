<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class RecruiterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recruteurs = User::where('role', 'recruteur')->latest()->get();
        return view('admin.recruiters', ['users' => $recruteurs]);
    }

    /**
     * Supprime un recruteur ou un candidat (et toutes ses données liées).
     */
    public function destroy(User $user)
    {
        // Un administrateur ne peut pas être supprimé depuis ces listes
        if ($user->hasRole('admin') || $user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Impossible de supprimer un administrateur.');
        }

        $role = $user->role; // Récupère le rôle de l'utilisateur avant suppression
        $user->delete();

        if ($role === 'recruteur') {
            return redirect()->route('admin.recruiters')->with('success', 'Recruteur supprimé avec succès.');
        }

        return redirect()->route('admin.candidates')->with('success', 'Candidat supprimé avec succès.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RecruiterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $recruteurs = User::where('role', 'recruteur')->get();
        return view('admin.recruiters', ['users' => $recruteurs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        $role = $user->role; // Récupère le rôle de l'utilisateur avant suppression
        $user->delete();

        if ($role === 'recruteur') {
            return redirect()->route('admin.recruiters')->with('success', 'Recruteur supprimé avec succès.');
        } else {
            return redirect()->route('admin.candidates')->with('success', 'Candidat supprimé avec succès.');
        }
    }
}

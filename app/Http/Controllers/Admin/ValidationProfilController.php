<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ValidationProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $candidats = User::role('candidat')
            -> where('status', 'en attente')
            ->get();
        return view('admin.profils.index', ['candidats' => $candidats]);
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
    public function show(User $user)
    {
        //
        return view('admin.profils.show', ['user'=>$user]);
    }

    public function valider(User $user)
    {
        $user->status = 'validee';
        $user->save();

        return redirect()->back()->with('message', 'Profil validée');
    }

    public function refuser(User $user)
    {
        $user->status = 'refusee';
        $user->save();

        return redirect()->back()->with('message', 'Profil refusée');
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
    public function destroy(string $id)
    {
        //
    }
}

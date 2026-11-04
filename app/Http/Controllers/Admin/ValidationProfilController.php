<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ProfilStatutNotification;

class ValidationProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Uniquement les candidats ayant créé un profil, ceux en attente en premier
        $candidats = User::role('candidat')
            ->whereHas('profil')
            ->with('profil')
            ->orderByRaw("status = ? desc", [User::STATUS_EN_ATTENTE])
            ->latest()
            ->get();
        return view('admin.profils.index', ['candidats' => $candidats]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        abort_unless($user->hasRole('candidat'), 404);

        return view('admin.profils.show', ['user' => $user]);
    }

    public function valider(User $user)
    {
        return $this->changerStatut($user, User::STATUS_VALIDEE, 'Profil validé');
    }

    public function refuser(User $user)
    {
        return $this->changerStatut($user, User::STATUS_REFUSEE, 'Profil refusé');
    }

    private function changerStatut(User $user, string $status, string $message)
    {
        abort_unless($user->hasRole('candidat'), 404);

        $user->status = $status;
        $user->save();

        // Email + notification au candidat (remplace les anciens Mailables ProfilValide/ProfilRefuse)
        $user->notify(new ProfilStatutNotification($status));

        return redirect()->back()->with('success', $message.'. Le candidat a été notifié par email.');
    }
}

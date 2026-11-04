<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\BienvenueNotification;
use App\Notifications\NouvelInscritNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Le formulaire d'inscription est une fenêtre modale de la page d'accueil.
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('index')->with('openModal', 'registername');
    }

    /**
     * Handle an incoming registration request.
     * Répond en JSON quand la requête vient de l'Ajax : la page n'est pas rechargée
     * et la modale de connexion s'ouvre directement.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:'.User::class,
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'password' => ['required', 'confirmed', Rules\Password::min(8)],
            // On n'autorise jamais la création d'un compte admin depuis le formulaire public
            'role' => ['required', 'string', 'in:recruteur,candidat'],
        ], [
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.confirmed' => 'Les deux mots de passe ne correspondent pas.',
            'role.in' => 'Rôle invalide.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->input('role'));
        event(new Registered($user));

        // Email de bienvenue + notification aux administrateurs
        $user->notify(new BienvenueNotification());
        Notification::send(User::role('admin')->get(), new NouvelInscritNotification($user));

        $message = 'Inscription réussie ! Un email de bienvenue vous a été envoyé. Connectez-vous maintenant.';

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'email' => $user->email,
            ], 201);
        }

        return redirect(route('index'))
            ->with('openModal', 'loginname')
            ->with('success', $message);
    }
}

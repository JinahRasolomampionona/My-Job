<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Le formulaire de connexion est une fenêtre modale de la page d'accueil :
     * on redirige vers l'accueil en demandant l'ouverture de cette modale.
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('index')->with('openModal', 'loginname');
    }

    /**
     * Handle an incoming authentication request.
     * Répond en JSON quand la requête vient de l'Ajax (pas de rechargement de page).
     */
    public function store(LoginRequest $request): RedirectResponse|JsonResponse
    {
        $request->ensureIsNotRateLimited();

        if (! User::where('email', $request->email)->exists()) {
            RateLimiter::hit($request->throttleKey());
            throw ValidationException::withMessages([
                'email' => 'Aucun compte ne correspond à cet email.',
            ]);
        }

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            RateLimiter::hit($request->throttleKey());
            throw ValidationException::withMessages([
                'password' => 'Mot de passe incorrect.',
            ]);
        }

        RateLimiter::clear($request->throttleKey());

        $request->session()->regenerate();

        $user = Auth::user();
        $redirect = redirect()->intended(route($user->homeRoute()));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Connexion réussie, bienvenue '.$user->name.' !',
                'redirect' => $redirect->getTargetUrl(),
            ]);
        }

        return $redirect;
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

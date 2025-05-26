<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Email invalide.',
            ]);
        }

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'password' => 'Mot de passe incorrect.',
            ]);
        }

        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        // dd(method_exists($user, "hasRole"));

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.index');
        } elseif ($user->hasRole('recruteur')) {
            return redirect()->route('recruteurs.recruteur');
        } elseif ($user->hasRole('candidat')) {
            return redirect()->route('candidats.candidat');
        }


        return redirect()->intended(route('index', absolute: false));
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

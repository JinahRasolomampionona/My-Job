<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    /**
     * Le formulaire "mot de passe oublié" est une fenêtre modale de la page d'accueil.
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('index')->with('openModal', 'forgotname');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        $messages = [
            Password::RESET_LINK_SENT => 'Un lien de réinitialisation vous a été envoyé par email.',
            Password::INVALID_USER => 'Aucun compte ne correspond à cet email.',
            Password::RESET_THROTTLED => 'Veuillez patienter avant de réessayer.',
        ];
        $message = $messages[$status] ?? __($status);

        if ($status != Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages(['email' => $message]);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return back()->with('openModal', 'forgotname')->with('status', $message);
    }
}

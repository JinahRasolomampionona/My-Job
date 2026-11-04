{{-- Formulaire "mot de passe oublié" (modale #forgotname), envoyé en Ajax --}}
<div class="box auth-box">
    <span class="borderLine"></span>
    <form action="{{ route('password.email') }}" method="POST" data-ajax="message" novalidate>
        @csrf
        <h3>Mot de passe oublié</h3>
        <p class="text-white small mt-3 mb-0">Indiquez votre adresse email : nous vous enverrons un lien pour choisir un nouveau mot de passe.</p>

        <div class="form-feedback" data-form-message>
            @if (session('status'))
                <div class="alert alert-success py-2 mb-0">{{ session('status') }}</div>
            @endif
        </div>

        <div class="inputBox">
            <input type="email" name="email" id="forgot-email" value="{{ old('email') }}" autocomplete="email" required>
            <span>Email</span>
            <i></i>
        </div>
        <small class="field-error" data-error-for="email">@error('email'){{ $message }}@enderror</small>

        <div class="links">
            <a href="{{ route('login') }}" data-switch-modal="#loginname">Retour à la connexion</a>
        </div>

        <button type="submit" id="submit" class="btn-submit">
            <span class="btn-label">Envoyer le lien</span>
        </button>
    </form>
</div>

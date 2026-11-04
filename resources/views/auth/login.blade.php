{{-- Formulaire de connexion (affiché dans la modale #loginname). Envoyé en Ajax : voir resources/js/app.js --}}
<div class="box shadow-lg auth-box">
    <span class="borderLine"></span>
    <form action="{{ route('login') }}" method="post" data-ajax="redirect" novalidate>
        @csrf
        <h3>Se connecter</h3>

        <div class="form-feedback" data-form-message>
            @if (session('success') && session('openModal') === 'loginname')
                <div class="alert alert-success py-2 mb-0">{{ session('success') }}</div>
            @endif
        </div>

        <!-- Email Address -->
        <div class="inputBox">
            <input type="email" name="email" id="login-email" value="{{ old('email') }}" autocomplete="email" required>
            <span>Email</span>
            <i></i>
        </div>
        <small class="field-error" data-error-for="email">@error('email'){{ $message }}@enderror</small>

        <!-- Password -->
        <div class="inputBox">
            <input type="password" name="password" id="login-password" autocomplete="current-password" required>
            <span>Mot de passe</span>
            <i></i>
            <button type="button" class="toggle-password" data-toggle-password="#login-password" aria-label="Afficher le mot de passe">
                <i class="fa-regular fa-eye"></i>
            </button>
        </div>
        <small class="field-error" data-error-for="password">@error('password'){{ $message }}@enderror</small>

        <!-- Remember Me -->
        <label for="login-remember" class="remember mt-3">
            <input id="login-remember" type="checkbox" name="remember">
            <span class="ms-2 text-white">Se souvenir de moi</span>
        </label>

        <div class="links">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" data-switch-modal="#forgotname">Mot de passe oublié ?</a>
            @endif
            <a href="{{ route('register') }}" data-switch-modal="#registername">S'inscrire</a>
        </div>

        <button type="submit" id="submit" class="btn-submit">
            <span class="btn-label">Se connecter</span>
        </button>
    </form>
</div>

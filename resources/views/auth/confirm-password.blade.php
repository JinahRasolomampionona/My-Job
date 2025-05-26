<div class="box">
    <span class="borderLine"></span>
    <form action="{{ route('password.confirm') }}" method="POST">
        @csrf
        <h2>Confirmer le mot de passe</h2>

        <p class="info-text">
            Ceci est une zone sécurisée de l'application. Veuillez confirmer votre mot de passe avant de continuer.
        </p>

        <!-- Mot de passe -->
        <div class="inputBox">
            <input type="password" name="password" id="password" required>
            <span>Mot de passe</span>
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
            <i></i>
        </div>

        <input type="submit" id="submit" value="Confirmer">
    </form>
</div>



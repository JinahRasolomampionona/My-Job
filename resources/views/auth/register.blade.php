{{-- Formulaire d'inscription (modale #registername). Envoyé en Ajax : en cas de succès,
     la modale de connexion s'ouvre directement, sans rechargement de la page. --}}
<div class="d-flex justify-content-center align-items-center regist w-100">
    <div class="card register-card shadow-lg p-4">
        <h3 class="text-center mb-3">Créer un compte</h3>
        <form method="POST" action="{{ route('register') }}" data-ajax="switch-login" novalidate>
            @csrf

            <div class="form-feedback" data-form-message></div>

            <!-- Rôle -->
            <div class="role-choice mb-3">
                <input type="radio" class="btn-check" name="role" id="reg-role-candidat" value="candidat" checked>
                <label class="role-option" for="reg-role-candidat">
                    <i class="fas fa-user-graduate"></i> Candidat
                </label>
                <input type="radio" class="btn-check" name="role" id="reg-role-recruteur" value="recruteur">
                <label class="role-option" for="reg-role-recruteur">
                    <i class="fas fa-building"></i> Recruteur
                </label>
            </div>
            <small class="field-error" data-error-for="role"></small>

            <!-- Name -->
            <div class="form-floating mb-2">
                <input type="text" id="reg-name" name="name" class="form-control" placeholder="Nom" autocomplete="name" required>
                <label for="reg-name">Nom complet</label>
                <small class="field-error" data-error-for="name"></small>
            </div>

            <!-- Email -->
            <div class="form-floating mb-2">
                <input type="email" id="reg-email" name="email" class="form-control" placeholder="Email" autocomplete="email" required>
                <label for="reg-email">Email</label>
                <small class="field-error" data-error-for="email"></small>
            </div>

            <!-- Password -->
            <div class="form-floating mb-2 position-relative">
                <input type="password" id="reg-password" name="password" class="form-control" placeholder="Mot de passe" autocomplete="new-password" required>
                <label for="reg-password">Mot de passe (8 caractères min.)</label>
                <button type="button" class="toggle-password dark" data-toggle-password="#reg-password" aria-label="Afficher le mot de passe">
                    <i class="fa-regular fa-eye"></i>
                </button>
                <div class="password-strength"><span data-strength-bar></span></div>
                <small class="field-error" data-error-for="password"></small>
            </div>

            <!-- Confirm Password -->
            <div class="form-floating mb-3">
                <input type="password" id="reg-password-confirmation" name="password_confirmation" class="form-control" placeholder="Confirmation" autocomplete="new-password" required>
                <label for="reg-password-confirmation">Confirmer le mot de passe</label>
                <small class="field-error" data-error-for="password_confirmation"></small>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('login') }}" class="text-decoration-none" data-switch-modal="#loginname">Déjà inscrit ?</a>
                <button type="submit" class="btn btn-primary btn-submit">
                    <span class="btn-label">S'inscrire</span>
                </button>
            </div>
        </form>
    </div>
</div>

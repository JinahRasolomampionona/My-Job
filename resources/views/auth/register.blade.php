<div class="container d-flex justify-content-center align-items-center regist">
    <div class="card shadow-lg p-4" style="width: 400px;">
        <h3 class="text-center mb-4">S'inscrire</h3>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                @error('name')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Role -->
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role">
                    <option value="admin">Admin</option>
                    <option value="recruteur">Recruteur</option>
                    <option value="candidat">Candidat</option>
                </select>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" id="password" name="password" class="form-control" required>
                @error('password')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>


            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                @error('password_confirmation')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('login') }}" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#loginname">Déjà inscris?</a>
                <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginname">S'inscrire</button>
            </div>
        </form>
    </div>
</div>



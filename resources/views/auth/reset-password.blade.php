@extends("auth.modal", ['name'=> 'resetModal'])
@section("title-section")
Réinitialisation du mot de passe
@endsection

@section("modal-section")
<div class="box">
    <span class="borderLine"></span>
    <form action="{{ route('password.store') }}" method="POST">
        @csrf
        <h2>Réinitialiser le mot de passe</h2>

        <!-- Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <div class="inputBox">
            <input type="email" name="email" id="email" value="{{ old('email', $request->email) }}" required>
            <span>Email</span>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
            <i></i>
        </div>

        <!-- Nouveau mot de passe -->
        <div class="inputBox">
            <input type="password" name="password" id="password" required>
            <span>Nouveau mot de passe</span>
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
            <i></i>
        </div>

        <!-- Confirmation du mot de passe -->
        <div class="inputBox">
            <input type="password" name="password_confirmation" id="password_confirmation" required>
            <span>Confirmer le mot de passe</span>
            @error('password_confirmation')
                <div class="error-message">{{ $message }}</div>
            @enderror
            <i></i>
        </div>

        <input type="submit" id="submit" value="Réinitialiser le mot de passe">
    </form>
</div>
@endsection


{{-- <!-- @extends("auth.modal", ['name'=> 'forgotModal']) --> --}}

<div class="box">
    <span class="borderLine"></span>
    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <p class="text-white">Vous avez oublié votre mot de passe ? Aucun problème. Indiquez-nous simplement votre adresse e-mail et nous vous enverrons par e-mail un lien de réinitialisation de mot de passe qui vous permettra d'en choisir un nouveau.</p>
        
        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="inputBox">
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            <span>Email</span>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
            <i></i>
        </div>
        
        <input type="submit" id="submit" value="Réinitialiser">
    </form>
</div>



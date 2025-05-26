<div class="box">
    <span class="borderLine"></span>
    <form action="{{ route('login') }}" method="post">
        @csrf
        <h3>Se connecter</h3>

        <!-- Email Address -->
        <div class="inputBox">
            @error('email')
                <div class="text-white">{{ $message }}</div>
            @enderror
            <i class="fa fa-envelope"></i>
            <input type="text" name="email" id="email" value="{{ old('email') }}" required autofocus>
            <span>Email</span>
            <i></i>
        </div>

        <!-- Password -->
        <div class="inputBox">
            @error('password')
                <div class="text-white">{{ $message }}</div>
            @enderror
            <input type="password" name="password" id="password" required>
            <span>Mot de passe</span>
            <i></i>
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember">
                <span class="ms-2 text-sm text-white">Se souvenir de moi</span>
            </label>
        </div>

        <div class="links">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" data-bs-toggle="modal" data-bs-target="#forgotname">Mot de
                    passe oublié?</a>
            @endif
            <a href="{{ route('register') }}" data-bs-toggle="modal" data-bs-target="#registername">S'inscrire</a>
        </div>

        <input type="submit" id="submit" value="Se connecter">
    </form>
</div>

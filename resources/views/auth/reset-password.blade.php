@extends('Layout.layout')
@section('title-section')
Réinitialisation du mot de passe
@endsection

@section('content-section')
<section class="auth-page d-flex justify-content-center align-items-center">
    <div class="box auth-box auth-box-lg" data-aos="zoom-in">
        <span class="borderLine"></span>
        <form action="{{ route('password.store') }}" method="POST">
            @csrf
            <h3>Nouveau mot de passe</h3>

            <!-- Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div class="inputBox">
                <input type="email" name="email" id="reset-email" value="{{ old('email', $request->email) }}" required>
                <span>Email</span>
                <i></i>
            </div>
            <small class="field-error">@error('email'){{ $message }}@enderror</small>

            <!-- Nouveau mot de passe -->
            <div class="inputBox">
                <input type="password" name="password" id="reset-password" required>
                <span>Nouveau mot de passe</span>
                <i></i>
            </div>
            <small class="field-error">@error('password'){{ $message }}@enderror</small>

            <!-- Confirmation du mot de passe -->
            <div class="inputBox">
                <input type="password" name="password_confirmation" id="reset-password-confirmation" required>
                <span>Confirmer le mot de passe</span>
                <i></i>
            </div>
            <small class="field-error">@error('password_confirmation'){{ $message }}@enderror</small>

            <button type="submit" id="submit" class="btn-submit">
                <span class="btn-label">Réinitialiser</span>
            </button>
        </form>
    </div>
</section>
@endsection

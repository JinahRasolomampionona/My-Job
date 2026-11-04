@extends("Layout.layout")
@section("title-section")
Creation offres
@endsection

@section("content-section")
<div class="container">
    <div class="page-offre">
        <div class="form-card" data-aos="fade-up">
            <h1>Insérer une offre</h1>
            <form method="post" action="{{ route('offers.store') }}">
                @csrf
                @include('offers._form')
                <button type="submit" class="btn-click" name="inserer">Insérer</button>
                <a href="{{ route('offers.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection

@extends("Layout.layout")
@section("title-section")
Modifier offres
@endsection

@section("content-section")
<div class="container">
    <div class="page-offre">
        <div class="form-card" data-aos="fade-up">
            <h1>Modifier l'offre</h1>
            <form method="post" action="{{ route('offers.update', $offresView->id) }}">
                @csrf
                @method('PUT')
                @include('offers._form', ['offre' => $offresView])
                <button type="submit" class="btn btn-primary" name="modifier">Modifier</button>
                <a href="{{ route('offers.show', $offresView->id) }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection

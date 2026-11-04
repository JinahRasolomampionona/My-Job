@extends('Layout.recruiter')
@section('title-section')
Modifier offres
@endsection

@section('content-section')
<div class="container">
    <div class="page-inner">
        <div class="form-card form-card-wide" data-aos="fade-up">
            <h1>Modifier l'offre</h1>
            <p class="text-muted"><i class="fas fa-circle-info me-1"></i>Après modification, l'offre devra de nouveau être validée par l'administrateur.</p>
            <form method="post" action="{{ route('recruiters.offers.update', $offre) }}">
                @csrf
                @include('offers._form', ['offre' => $offre])
                <button type="submit" class="btn btn-primary" name="modifier">Enregistrer</button>
                <a href="{{ route('recruiters.offers.show', $offre) }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection

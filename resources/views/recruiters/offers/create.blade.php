@extends('Layout.recruiter')
@section('title-section')
Creation offres
@endsection


@section('content-section')
<div class="container">
    <div class="page-inner">
        <div class="form-card form-card-wide" data-aos="fade-up">
            <h1>Publier une offre</h1>
            <p class="text-muted">Votre offre sera visible par les candidats après validation par l'administrateur.</p>
            <form method="post" action="{{ route('recruiters.offers.store') }}">
                @csrf
                @include('offers._form')
                <button type="submit" class="btn btn-primary" name="inserer"><i class="fas fa-paper-plane me-1"></i>Publier</button>
                <a href="{{ route('recruiters.offers.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection

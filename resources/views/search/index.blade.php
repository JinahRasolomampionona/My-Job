@extends('Layout.layout')
@section('title-section')
Recherche d'offres
@endsection


@section('content-section')
<section class="home home-small">
    <div class="container-fluid">
        <form action="{{ route('search.index') }}" method="get" class="search-form" data-aos="fade-down">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" name="titre" class="form-control" placeholder="Quel job vous fait vibrer ?"
                    value="{{ $input['titre'] ?? '' }}" aria-label="Poste ou entreprise">
                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                <input type="text" class="form-control" name="localisation" placeholder="Où voulez-vous briller ?"
                    value="{{ $input['localisation'] ?? '' }}" aria-label="Localisation">
                <span class="input-group-text"><button type="submit" class="btn-click">Rechercher</button></span>
            </div>
        </form>
    </div>
</section>
<section class="offres">
    <div class="container section-title my-8" data-aos="fade-up">
        <h2>{{ $offres->count() }} résultat(s)
            @if (!empty($input['titre'])) pour <b>{{ $input['titre'] }}</b> @endif
            @if (!empty($input['localisation'])) à <b>{{ $input['localisation'] }}</b> @endif
        </h2>
    </div>
    <div class="container">
        <div class="row gy-4">
            @forelse ($offres as $offre)
                <x-offer-card :offre="$offre" :url="route('offers.show', $offre->id)" :delay="$loop->index * 100" />
            @empty
                <x-empty-state icon="fa-magnifying-glass" message="Aucune offre ne correspond à votre recherche." />
            @endforelse
        </div>
    </div>
</section>
@endsection

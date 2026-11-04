@extends('Layout.candidate')
@section('title-section')
Page offres
@endsection

@section('content-section')
<div class="container offres">
    <div class="page-inner" data-live-results>
        <h3 class="fw-bold mb-0" data-aos="fade-down">
            Offres d'emploi
            @if (request('titre') || request('localisation'))
                <small class="text-muted fs-6">({{ $offresView->count() }} résultat(s))
                    <a href="{{ route('candidates.offers.index') }}" class="ms-1">Réinitialiser</a></small>
            @endif
        </h3>
        <div class="row gy-4 my-2">
            @forelse ($offresView as $offre)
                <x-offer-card :offre="$offre" :url="route('candidates.offers.show', $offre)" :delay="($loop->index % 3) * 100" />
            @empty
                <x-empty-state icon="fa-briefcase" message="Aucune offre ne correspond pour le moment." />
            @endforelse
        </div>
    </div>
</div>
@endsection

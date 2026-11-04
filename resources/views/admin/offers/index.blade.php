@extends('Layout.admin')
@section('title-section')
Page offres
@endsection

@section('content-section')
<div class="container offres">
    <div class="page-inner" data-live-results>
        <h3 class="fw-bold mt-3" data-aos="fade-down">
            Validation des offres
            @if ($titre)
                <small class="text-muted fs-6">({{ $offresView->count() }} résultat(s) pour « {{ $titre }} »)
                    <a href="{{ route('admin.offers.index') }}" class="ms-1">Réinitialiser</a></small>
            @endif
        </h3>
        <p class="text-muted">Les offres en attente sont affichées en premier.</p>
        <div class="row gy-4 my-2">
            @forelse ($offresView as $offre)
                <x-offer-card :offre="$offre" :url="route('admin.offers.show', $offre)" :show-status="true"
                    :delay="($loop->index % 3) * 100" />
            @empty
                <x-empty-state icon="fa-check-double" message="{{ $titre ? 'Aucune offre ne correspond à votre recherche.' : 'Aucune offre pour le moment.' }}" />
            @endforelse
        </div>
    </div>
</div>
@endsection

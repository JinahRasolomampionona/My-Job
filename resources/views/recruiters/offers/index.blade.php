@extends('Layout.recruiter')
@section('title-section')
Page offres
@endsection

@section('content-section')
<div class="container offres">
    <div class="page-inner">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2" data-aos="fade-down">
            <h3 class="fw-bold mb-0">Mes offres</h3>
            <a href="{{ route('recruiters.offers.create') }}" class="btn-click"><i class="fas fa-plus me-1"></i>Créer une offre</a>
        </div>
        <div class="row gy-4 my-2">
            @forelse ($offresView as $offre)
                <x-offer-card :offre="$offre" :url="route('recruiters.offers.show', $offre)" :show-status="true"
                    :delay="($loop->index % 3) * 100" />
            @empty
                <x-empty-state icon="fa-briefcase" message="Vous n'avez publié aucune offre pour le moment.">
                    <a href="{{ route('recruiters.offers.create') }}" class="btn btn-primary mt-2">Publier ma première offre</a>
                </x-empty-state>
            @endforelse
        </div>
    </div>
</div>
@endsection

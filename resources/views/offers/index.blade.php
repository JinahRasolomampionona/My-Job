@extends('Layout.layout')
@section('title-section')
Page offres
@endsection

@section('content-section')
<div class="container offres">
    <div class="page-offre">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2" data-aos="fade-down">
            <h2 class="mb-0">Toutes les offres d'emploi</h2>
            @auth
                @role('admin')
                    <a href="{{ route('offers.create') }}" class="btn-click">Créer une offre</a>
                @endrole
            @endauth
        </div>
        <div class="row gy-4 my-2">
            @forelse ($offresView as $offre)
                <x-offer-card :offre="$offre" :url="route('offers.show', $offre->id)" :delay="($loop->index % 3) * 100" />
            @empty
                <x-empty-state icon="fa-briefcase" message="Aucune offre publiée pour le moment." />
            @endforelse
        </div>
    </div>
</div>
@endsection

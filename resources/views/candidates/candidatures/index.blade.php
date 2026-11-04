@extends('Layout.candidate')
@section('title-section')
Mes candidatures
@endsection

@section('content-section')
<div class="container">
    <div class="page-inner">
        <h3 class="fw-bold mb-4" data-aos="fade-down"><i class="fas fa-paper-plane text-primary me-2"></i>Mes candidatures</h3>

        <div class="row g-3">
            @forelse ($candidatures as $candidature)
                <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ min($loop->index * 80, 400) }}">
                    <div class="candidature-item h-100">
                        <div class="avatar-initials"><i class="fas fa-briefcase"></i></div>
                        <div class="flex-grow-1">
                            @if ($candidature->offre)
                                <a href="{{ route('candidates.offers.show', $candidature->offre) }}" class="fw-bold">
                                    {{ $candidature->offre->titre }}</a>
                                <span class="d-block text-muted">{{ $candidature->offre->entreprise }} · {{ $candidature->offre->localisation }}</span>
                            @else
                                <strong class="text-muted">Offre supprimée</strong>
                            @endif
                            <small class="text-muted">Envoyée {{ $candidature->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <x-empty-state icon="fa-paper-plane" message="Vous n'avez encore postulé à aucune offre.">
                    <a href="{{ route('candidates.offers.index') }}" class="btn btn-primary mt-2">Voir les offres</a>
                </x-empty-state>
            @endforelse
        </div>
    </div>
</div>
@endsection

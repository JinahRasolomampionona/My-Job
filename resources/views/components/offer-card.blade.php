{{-- Carte d'une offre, utilisée dans toutes les listes d'offres --}}
@props(['offre', 'url', 'showStatus' => false, 'delay' => 0])

@php
    $statusClass = match ($offre->status) {
        'validee' => 'bg-success',
        'refusee' => 'bg-danger',
        default => 'bg-warning text-dark',
    };
    $statusLabel = match ($offre->status) {
        'validee' => 'Validée',
        'refusee' => 'Refusée',
        default => 'En attente',
    };
@endphp

<div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ min($delay, 400) }}">
    <article class="offer-card {{ $offre->is_urgent ? 'is-urgent' : '' }}">
        <div class="row">
            <div class="col-10">
                <div class="offer-badges">
                    @if ($showStatus)
                        <span class="badge status {{ $statusClass }}">{{ $statusLabel }}</span>
                    @endif
                    @if ($offre->is_urgent)
                        <span class="badge urgent bg-danger"><i class="fas fa-bolt me-1"></i>Urgent</span>
                    @endif
                    @isset($offre->candidatures_count)
                        <span class="badge bg-info text-dark"><i class="fas fa-users me-1"></i>{{ $offre->candidatures_count }} candidature(s)</span>
                    @endisset
                </div>
                <h3 class="post-category text-upper"><a href="{{ $url }}">{{ $offre->titre }}</a></h3>
                <h4 class="post-society text-upper"><a href="{{ $url }}">{{ $offre->entreprise }}</a></h4>
                <p class="local-icon">
                    <i class="fas fa-map-marker-alt"></i>{{ $offre->localisation }} ~
                    <span class="text-upper">{{ $offre->contrat }}</span>
                </p>
                <p>Domaine : {{ $offre->domaine }}</p>
                <p class="date-create">{{ $offre->created_at?->format('d-m-Y') }}</p>
            </div>
            <div class="col-2 d-flex justify-content-center align-items-center icons">
                <a href="{{ $url }}" aria-label="Voir l'offre"><i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </article>
</div>

{{-- Liste paginée des offres de la page d'accueil (rechargée en AJAX lors d'une recherche ou d'un changement de page) --}}
<div class="container">
    <div class="lp-section-head">
        @if ($isSearch)
            <h2>
                {{ $offresView->total() }} résultat{{ $offresView->total() > 1 ? 's' : '' }}
                @if (!empty($input['titre'])) pour «&nbsp;{{ $input['titre'] }}&nbsp;» @endif
                @if (!empty($input['localisation'])) à {{ $input['localisation'] }} @endif
            </h2>
            <a href="{{ route('index') }}#offres" class="lp-link" data-home-search-reset>Effacer la recherche</a>
        @else
            <h2>Des entreprises qui recrutent</h2>
        @endif
    </div>
    <div class="row gy-4">
        @forelse ($offresView as $offre)
            <x-offer-card :offre="$offre" :url="route('offers.show', $offre->id)" :delay="$loop->index * 100" />
        @empty
            @if ($isSearch)
                <x-empty-state icon="fa-magnifying-glass" message="Aucune offre ne correspond à votre recherche." />
            @else
                <x-empty-state icon="fa-briefcase" message="Aucune offre publiée pour le moment, revenez bientôt !" />
            @endif
        @endforelse
    </div>
    @if ($offresView->hasPages())
        <nav class="lp-pagination" aria-label="Pagination des offres">
            {{ $offresView->links('pagination::bootstrap-5') }}
        </nav>
    @endif
</div>

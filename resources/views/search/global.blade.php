@extends($layout)
@section('title-section')
Recherche
@endsection

@section('content-section')
@php
    // Met en évidence le mot recherché (texte échappé avant le surlignage)
    $surligner = fn (?string $texte) => $q === '' ? e($texte)
        : preg_replace('/(' . preg_quote(e($q), '/') . ')/iu', '<mark>$1</mark>', e($texte));
@endphp
<div class="container">
    <div class="page-inner global-search" data-live-results>
        <h3 class="fw-bold mt-3 mb-1">
            <i class="fas fa-magnifying-glass text-primary me-2"></i>Recherche
            @if ($q !== '')
                <small class="text-muted fs-6">
                    {{ $total }} résultat{{ $total > 1 ? 's' : '' }} pour « {{ $q }} »
                    <a href="{{ route('dashboard.search') }}" class="ms-1">Réinitialiser</a>
                </small>
            @endif
        </h3>
        <p class="text-muted">La recherche parcourt toutes les rubriques de votre espace.</p>

        @if ($q === '')
            <div class="row">
                <x-empty-state icon="fa-keyboard" message="Tapez un mot-clé dans la barre de recherche en haut de la page." />
            </div>
        @elseif (empty($groupes))
            <div class="row">
                <x-empty-state icon="fa-magnifying-glass" message="Aucun résultat dans votre espace pour cette recherche." />
            </div>
        @else
            <div class="row g-4">
                @foreach ($groupes as $groupe)
                    <div class="col-xl-6">
                        <section class="gs-group">
                            <header class="gs-group-head">
                                <h4><i class="fas {{ $groupe['icone'] }} me-2"></i>{{ $groupe['titre'] }}
                                    <span class="badge bg-light text-dark ms-1">{{ $groupe['total'] }}</span>
                                </h4>
                                @if ($groupe['total'] > count($groupe['items']))
                                    <a href="{{ $groupe['voir_tout'] }}" class="gs-all">Voir tout</a>
                                @endif
                            </header>
                            <ul class="gs-list">
                                @foreach ($groupe['items'] as $item)
                                    <li>
                                        <a href="{{ $item['url'] }}" class="gs-item">
                                            <span class="gs-item-main">
                                                <span class="gs-item-title">{!! $surligner($item['titre']) !!}</span>
                                                @if (!empty($item['sous_titre']))
                                                    <span class="gs-item-sub">{!! $surligner(\Illuminate\Support\Str::limit($item['sous_titre'], 110)) !!}</span>
                                                @endif
                                            </span>
                                            <span class="gs-item-side">
                                                @if (!empty($item['badge']))
                                                    <span class="badge {{ $item['badge'][1] }}">{{ $item['badge'][0] }}</span>
                                                @endif
                                                @if (!empty($item['extra']))
                                                    <small class="text-muted">{{ $item['extra'] }}</small>
                                                @endif
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </section>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

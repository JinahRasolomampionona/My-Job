@extends('Layout.layout')
@section('title-section')
Page d'accueil
@endsection


@section('content-section')
<div class="landing">

    {{-- Hero : recherche + offres publiées en direct --}}
    <section class="lp-hero">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-7 lp-hero-main">
                    <h1 class="lp-hero-title">Notre job&nbsp;: vous aider à choisir le vôtre.</h1>
                    <p class="lp-hero-lead">
                        {{ $totalOffres }} offre{{ $totalOffres > 1 ? 's' : '' }} vérifiée{{ $totalOffres > 1 ? 's' : '' }} par notre équipe,
                        publiée{{ $totalOffres > 1 ? 's' : '' }} par des entreprises qui recrutent à Madagascar.
                    </p>

                    <form action="{{ route('index') }}#offres" method="get" class="lp-search" role="search" data-home-search>
                        <label class="lp-search-field">
                            <i class="fas fa-search" aria-hidden="true"></i>
                            <span class="visually-hidden">Poste, entreprise ou domaine</span>
                            <input type="text" name="titre" placeholder="Poste, entreprise ou domaine" value="{{ $input['titre'] ?? '' }}">
                        </label>
                        <label class="lp-search-field">
                            <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                            <span class="visually-hidden">Ville</span>
                            <input type="text" name="localisation" placeholder="Ville" value="{{ $input['localisation'] ?? '' }}">
                        </label>
                        <button type="submit" class="lp-search-btn">Rechercher</button>
                    </form>

                    <div class="lp-suggestions" data-home-suggestions>
                        <span>Recherches fréquentes</span>
                        <a href="{{ route('index', ['titre' => 'stage']) }}#offres">Stage</a>
                        <a href="{{ route('index', ['titre' => 'CDI']) }}#offres">CDI</a>
                        @foreach (array_slice($footerDomaines, 0, 3) as $domaine)
                            <a href="{{ route('index', ['titre' => $domaine['nom']]) }}#offres">{{ $domaine['nom'] }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-5 lp-hero-side">
                    <div class="lp-live">
                        <div class="lp-live-head">
                            <span class="lp-live-dot" aria-hidden="true"></span>
                            <h2>Publiées récemment</h2>
                        </div>
                        @forelse ($dernieresOffres as $offre)
                            <a class="lp-live-item" href="{{ route('offers.show', $offre->id) }}">
                                <span class="lp-live-title">{{ $offre->titre }}</span>
                                <span class="lp-live-meta">
                                    {{ $offre->entreprise }}, {{ $offre->localisation }}
                                </span>
                                <span class="lp-live-time">{{ $offre->created_at?->diffForHumans() }}</span>
                            </a>
                        @empty
                            <p class="lp-live-empty">Les nouvelles offres apparaîtront ici dès leur validation.</p>
                        @endforelse
                        <a class="lp-live-all" href="{{ route('offers.index') }}">Toutes les offres</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Offres : résultats de la recherche du hero, paginés par 6 --}}
    <section class="offres lp-section lp-offres" id="offres" data-home-offers aria-live="polite">
        @include('home._offres')
    </section>

    {{-- Pourquoi My-Job --}}
    <section class="lp-section lp-why">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="lp-why-visual">
                        <img src="{{ Vite::asset('resources/images/img3.jpg') }}" alt="Illustration du suivi de candidature étape par étape" loading="lazy">
                    </div>
                </div>
                <div class="col-lg-6">
                    <h2 class="lp-why-title">Trouver un job, sans zones d'ombre</h2>
                    <ul class="lp-why-list">
                        <li>
                            <i class="fas fa-route" aria-hidden="true"></i>
                            <div>
                                <h3>Suivez votre candidature</h3>
                                <p>Chaque étape s'affiche en direct. Dès que le recruteur avance sur votre dossier, vous êtes prévenu.</p>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-file-lines" aria-hidden="true"></i>
                            <div>
                                <h3>Des offres qui ne cachent rien</h3>
                                <p>Contrat, lieu, domaine, missions : vous savez à quoi vous postulez avant de cliquer.</p>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-building-circle-check" aria-hidden="true"></i>
                            <div>
                                <h3>Des entreprises vérifiées</h3>
                                <p>Chaque offre est relue et validée par notre équipe avant d'être publiée.</p>
                            </div>
                        </li>
                    </ul>
                    <a href="{{ route('offers.index') }}" class="btn-click">Trouver mon job</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Candidat / Recruteur --}}
    <section class="lp-section lp-audience">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="lp-panel lp-panel-candidate">
                        <h2>Je cherche un emploi</h2>
                        <p>Créez votre profil professionnel et accédez aux meilleures opportunités de Madagascar.</p>
                        <ul>
                            <li><i class="fas fa-check" aria-hidden="true"></i>Profil professionnel personnalisé</li>
                            <li><i class="fas fa-check" aria-hidden="true"></i>Alertes sur les nouvelles offres</li>
                            <li><i class="fas fa-check" aria-hidden="true"></i>Échange direct avec les recruteurs</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn-click" data-bs-toggle="modal"
                            data-bs-target="#registername">Créer mon profil</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="lp-panel lp-panel-recruiter">
                        <h2>Je recrute</h2>
                        <p>Publiez vos offres et trouvez les bons talents parmi des profils qualifiés.</p>
                        <ul>
                            <li><i class="fas fa-check" aria-hidden="true"></i>Accès aux profils de candidats validés</li>
                            <li><i class="fas fa-check" aria-hidden="true"></i>Suivi des candidatures reçues par offre</li>
                            <li><i class="fas fa-check" aria-hidden="true"></i>Contact direct avec les candidats</li>
                        </ul>
                        <a href="{{ route('register') }}" class="lp-btn-light" data-bs-toggle="modal"
                            data-bs-target="#registername">Publier une offre</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Outils --}}
    <section class="lp-section lp-tools">
        <div class="container">
            <div class="lp-section-head">
                <h2>Les outils pour décrocher le poste</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-6">
                    <a href="#" class="lp-tool">
                        <img src="{{ Vite::asset('resources/images/cv-desk.png') }}" alt="" loading="lazy">
                        <div>
                            <h3>Créer votre CV en ligne</h3>
                            <p>Un CV clair et à jour en quelques minutes, grâce à notre outil gratuit.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="#" class="lp-tool">
                        <img src="{{ Vite::asset('resources/images/motif.jpg') }}" alt="" loading="lazy">
                        <div>
                            <h3>Rédiger votre lettre de motivation</h3>
                            <p>Nos conseils de rédaction et des exemples pour convaincre dès la première ligne.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

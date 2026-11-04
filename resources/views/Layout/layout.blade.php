<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ Vite::asset('resources/images/favicon.png') }}" type="image/png">
    <title>My-Job : @yield('title-section')</title>
    <!-- Fontawesome CSS -->
    @vite(['resources/librairies/fontawesome-free-6.1.1-web/css/all.min.css'])
    <!-- CSS -->
    <!-- Police des titres -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500..800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/global.css', 'resources/css/responsive.css', 'resources/css/home.css'])
</head>

{{-- data-open-modal : modale à ouvrir au chargement (ex: après une redirection vers /login) --}}
<body data-open-modal="{{ session('openModal') }}">
    <div class="page-progress" id="pageProgress"></div>
    <main>
        <header>
            <div class="header fixed-top bg-white" id="siteHeader">
                <nav class="navbar navbar-expand-lg navbar-light bg-white">
                    <div class="container">
                        <a href="{{ route('index') }}" class="logo d-flex">
                            <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="Logo">
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}" href="{{ route('index') }}">Accueil</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownEmploi"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Emploi
                                        <i class="fas fa-chevron-down toggle-dropdown"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownEmploi">
                                        <li><a class="dropdown-item" href="{{ route('offers.index') }}">Offres d'emploi</a></li>
                                        <li><a class="dropdown-item" href="{{ route('search.index', ['titre' => 'stage']) }}">Offres de stage</a></li>
                                        @guest
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#registername">Déposer mon CV</a></li>
                                        @endguest
                                    </ul>
                                </li>
                                @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginname">Recruteur</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginname">Candidat</a>
                                </li>
                                @endguest
                            </ul>
                            @guest
                                <a href="{{ route('login') }}" class="btn-click align-self-start"
                                    data-bs-toggle="modal" data-bs-target="#loginname">Se connecter</a>
                            @else
                                <div class="d-flex align-items-center gap-2">
                                    <x-notification-bell />
                                    <a href="{{ route('dashboard') }}" class="btn-click">
                                        <i class="fas fa-user me-1"></i> Mon espace
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button class="btn btn-outline-danger btn-sm" type="submit" title="Se déconnecter">
                                            <i class="fa-solid fa-right-from-bracket"></i>
                                        </button>
                                    </form>
                                </div>
                            @endguest
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        @yield('content-section')
        <footer class="site-footer">
            <div class="container">
                {{-- Bandeau d'appel à l'action --}}
                <div class="sf-cta">
                    <h2>Votre prochain poste est peut-être déjà en ligne.</h2>
                    <div class="sf-cta-actions">
                        <a href="{{ route('offers.index') }}" class="sf-btn sf-btn-solid">
                            Voir les {{ $footerTotalOffres }} offre{{ $footerTotalOffres > 1 ? 's' : '' }}
                        </a>
                        @guest
                            <a href="{{ route('register') }}" class="sf-btn sf-btn-ghost" data-bs-toggle="modal"
                                data-bs-target="#registername">Déposer mon CV</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="sf-btn sf-btn-ghost">Mon espace</a>
                        @endguest
                    </div>
                </div>

                <div class="sf-grid">
                    <div class="sf-about">
                        <a href="{{ route('index') }}" class="sf-brand">MyJob</a>
                        <p>La plateforme d'emploi qui relie les candidats et les entreprises de Madagascar, avec des offres vérifiées une à une.</p>
                        <div class="sf-social">
                            <a href="#" aria-label="MyJob sur Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" aria-label="MyJob sur LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                            <a href="#" aria-label="MyJob sur Instagram"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>

                    <nav class="sf-col" aria-label="Candidats">
                        <h3>Candidats</h3>
                        <ul>
                            <li><a href="{{ route('offers.index') }}">Offres d'emploi</a></li>
                            <li><a href="{{ route('search.index', ['titre' => 'stage']) }}">Offres de stage</a></li>
                            @guest
                                <li><a href="{{ route('register') }}" data-bs-toggle="modal" data-bs-target="#registername">Créer mon profil</a></li>
                                <li><a href="{{ route('login') }}" data-bs-toggle="modal" data-bs-target="#loginname">Se connecter</a></li>
                            @else
                                <li><a href="{{ route('dashboard') }}">Mon espace</a></li>
                            @endguest
                        </ul>
                    </nav>

                    <nav class="sf-col" aria-label="Recruteurs">
                        <h3>Recruteurs</h3>
                        <ul>
                            @guest
                                <li><a href="{{ route('register') }}" data-bs-toggle="modal" data-bs-target="#registername">Publier une offre</a></li>
                                <li><a href="{{ route('login') }}" data-bs-toggle="modal" data-bs-target="#loginname">Espace recruteur</a></li>
                            @else
                                <li><a href="{{ route('dashboard') }}">Espace recruteur</a></li>
                            @endguest
                            <li><a href="{{ route('offers.index') }}">Offres publiées</a></li>
                        </ul>
                    </nav>

                    <nav class="sf-col sf-domains" aria-label="Domaines qui recrutent">
                        <h3>Domaines qui recrutent</h3>
                        @if (count($footerDomaines))
                            <ul>
                                @foreach ($footerDomaines as $domaine)
                                    <li>
                                        <a href="{{ route('search.index', ['titre' => $domaine['nom']]) }}">
                                            <span>{{ $domaine['nom'] }}</span>
                                            <span class="sf-count">{{ $domaine['total'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="sf-muted">Les domaines apparaîtront ici avec les premières offres.</p>
                        @endif
                    </nav>
                </div>
            </div>

            {{-- Grand mot-symbole, coupé en bas de page --}}
            <div class="sf-wordmark" aria-hidden="true">MyJob</div>

            <div class="sf-bottom">
                <div class="container">
                    <span>&copy; {{ date('Y') }} MyJob. Tous droits réservés.</span>
                    <span>Fait à Madagascar</span>
                </div>
            </div>
        </footer>
    </main>

    {{-- Modales d'authentification disponibles sur toutes les pages publiques --}}
    @guest
        <x-form-modal name="loginname">
            @include('auth.login')
        </x-form-modal>
        <x-form-modal name="registername">
            @include('auth.register')
        </x-form-modal>
        <x-form-modal name="forgotname">
            @include('auth.forgot-password')
        </x-form-modal>
    @endguest

    <button type="button" class="back-to-top" id="backToTop" aria-label="Retour en haut"><i class="fas fa-arrow-up"></i></button>
    <x-flash />
    @vite(['resources/js/app.js'])
</body>

</html>

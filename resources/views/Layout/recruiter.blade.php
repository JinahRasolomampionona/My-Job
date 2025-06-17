<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ Vite::asset('resources/images/favicon.png') }}" type="image/png">
    <title>My-Job : @yield('title-section')</title>
    <!-- Fontawesome CSS -->
    @vite(['resources/librairies/fontawesome-free-6.1.1-web/css/all.min.css'])
    <!-- CSS -->
    @vite(['resources/css/app.css', 'resources/css/global.css', 'resources/css/sidebar.css'])
</head>

<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-heading border-bottom">
            <a href="{{ route('index') }}" class="logo-sidebar d-flex">
                <img src="{{ Vite::asset('resources/images/My-job.png') }}" alt="Logo">
            </a>
        </div>

        <a href="{{ route('recruiters.recruiter') }}" class="page">
            <i class="fas fa-home me-2"></i>Page Recruteur<i class="fas fa-chevron-right i-page"></i>
        </a>

        <a href="{{ route('recruiters.offers.index') }}"
            class="{{ Route::currentRouteName() == 'recruiters.offers.index' ? 'active' : '' }}">
            <i class="fas fa-layer-group me-2"></i>Gestion des offres
        </a>

        <a href="{{ route('recruiters.profils.index') }}"
            class="{{ Route::currentRouteName() == 'recruiters.profils.index' ? 'active' : '' }}">
            <i class="fas fa-users me-2"></i>Voir les profils
        </a>

        <a href="#">
            <i class="fas fa-bell me-2"></i>Notifications
            <span class="badge bg-primary ms-2">2</span>
        </a>
        <div class="sidebar-footer border-top">
            <a class="profile-pic d-flex align-items-center" href="#" aria-expanded="false">
                <div class="avatar-sm box-img">
                    <img src="{{ Vite::asset('resources/images/im1.jpg') }}" alt="..."
                        class="avatar-img rounded-circle" />
                </div>
                <span class="profile-username">
                    <span class="op-7">Hi,</span>
                    <span class="fw-bold">
                        @auth
                        {{ \Illuminate\Support\Facades\Auth::user()->name }}
                        @endauth
                        @guest
                        <a href="{{ route('login') }}">Se connecter</a>
                        @endguest
                    </span>
                </span>
            </a>
        </div>
    </div>

    <nav class="top-navbar" id="topNavbar">
        <button class="btn btn-outline-secondary" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>
        <form class="d-flex flex-grow-1 mx-3" style="max-width: 700px;">
            <input class="form-control me-2" type="search" placeholder="Quel job vous fait vibrer ?">
            <input class="form-control me-2" type="search" placeholder="Où voulez-vous briller ?">
            <button class="btn btn-primary" type="submit">Rechercher</button>
        </form>
        <div class="d-flex align-items-center">
            <button type="button" class="btn me-2" data-bs-toggle="popover"
                data-bs-content="Vous avez 1 nouveau message">
                <i class="fas fa-envelope"></i>
            </button>
            <button type="button" class="btn me-2 dropdown-toggle" data-bs-content="2 nouvelles notifications" 
            id="dropdownNotif" data-bs-toggle="dropdown">
                <i class="fas fa-bell"></i>
                <span class="notification">2</span>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownNotif">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-envelope"></i> 2 messages</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-bell"></i> message 1</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-bell"></i> message 2</a></li>
                </ul>
            </button>
            <a class="profile-pic d-flex align-items-center dropdown-toggle" href="#" aria-expanded="false" 
            id="dropdownUser" data-bs-toggle="dropdown">
                <div class="avatar-sm box-img">
                    <img src="{{ Vite::asset('resources/images/im1.jpg') }}" alt="..."
                        class="avatar-img rounded-circle" />
                </div>
                <span class="profile-username">
                    <span class="op-7">Hi,</span>
                    <span class="fw-bold">
                        @auth
                        {{ \Illuminate\Support\Facades\Auth::user()->name }}
                        @endauth
                        @guest
                        <a href="{{ route('login') }}">Se connecter</a>
                        @endguest
                    </span>
                </span>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                    <li><a class="dropdown-item" href="#"><i class="fa fa-user"></i> Mon profil</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</a></li>
                </ul>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button class="btn btn-outline-danger" type="submit">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </nav>

    <div class="content-wrapper" id="contentWrapper">
        @yield('content-section')

        <footer class="footer">
            <span>© 2025 My-Job. Tous droits réservés.</span>
            <div>
                <a href="#" data-bs-toggle="tooltip" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" data-bs-toggle="tooltip" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" data-bs-toggle="tooltip" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" data-bs-toggle="tooltip" title="GitHub"><i class="fab fa-github"></i></a>
            </div>
        </footer>
    </div>

    @vite(['resources/js/app.js'])
</body>

</html>
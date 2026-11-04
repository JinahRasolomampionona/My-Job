{{-- Base commune des espaces Candidat et Recruteur (voir Layout/candidate et Layout/recruiter) --}}
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
    @vite(['resources/css/app.css', 'resources/css/global.css', 'resources/css/sidebar.css',
    'resources/css/responsive.css'])
</head>

<body class="dashboard-body" data-open-modal="{{ old('_modal') }}">
    <div class="page-progress" id="pageProgress"></div>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-heading">
            <a href="{{ route('index') }}" class="logo-sidebar" title="Accueil My-Job">
                <img class="logo-full" src="{{ Vite::asset('resources/images/My-job.png') }}" alt="My-Job">
                <img class="logo-mini" src="{{ Vite::asset('resources/images/favicon.png') }}" alt="My-Job">
            </a>
        </div>

        <nav class="sidebar-nav">
            @yield('sidebar-links')

            @php $sidebarUnread = auth()->user()->unreadNotifications()->count(); @endphp
            <a href="{{ route('notifications.index') }}"
                class="{{ request()->routeIs('notifications.index') ? 'active' : '' }}" title="Notifications">
                <i class="fas fa-bell sidebar-icon"></i><span class="sidebar-label">Notifications</span>
                <span class="badge bg-primary sidebar-badge {{ $sidebarUnread ? '' : 'd-none' }}" data-notif-count>{{ $sidebarUnread }}</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="profile-pic d-flex align-items-center" title="{{ auth()->user()->name }}">
                <div class="avatar-sm box-img avatar-initials">
                    {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="profile-username sidebar-label">
                    <span class="op-7">Bonjour,</span>
                    <span class="fw-bold">{{ auth()->user()->name }}</span>
                </span>
            </div>
        </div>
    </div>
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <nav class="top-navbar" id="topNavbar">
        <button class="btn btn-outline-secondary" id="toggleSidebar" aria-label="Menu">
            <i class="fas fa-bars"></i>
        </button>

        <form class="d-flex flex-grow-1 mx-3 topbar-search" role="search" data-live-search
            action="{{ route('dashboard.search') }}" method="get">
            <input class="form-control me-2" type="search" name="q" value="{{ request()->routeIs('dashboard.search') ? request('q') : '' }}"
                autocomplete="off" placeholder="Rechercher dans mon espace..." aria-label="Rechercher dans mon espace">
            <button class="btn btn-primary" type="submit" aria-label="Rechercher"><i class="fas fa-search"></i></button>
        </form>

        <div class="d-flex align-items-center gap-2 ms-auto">
            <x-notification-bell />

            <div class="dropdown">
                <a class="profile-pic d-flex align-items-center dropdown-toggle" href="#" role="button"
                    id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar-sm box-img avatar-initials">
                        {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="profile-username d-none d-md-inline">
                        <span class="op-7">Bonjour,</span>
                        <span class="fw-bold">{{ auth()->user()->name }}</span>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                    <li class="dropdown-header">{{ auth()->user()->email }}</li>
                    @yield('user-menu')
                    <li><a class="dropdown-item" href="{{ route('notifications.index') }}"><i class="fas fa-bell me-2"></i>Notifications</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit">
                                <i class="fa-solid fa-right-from-bracket me-2"></i>Se déconnecter
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content-wrapper" id="contentWrapper">
        <div class="page-content" data-live-search-host>
            @yield('content-section')
        </div>

        <footer class="footer">
            <span>© {{ date('Y') }} My-Job. Tous droits réservés.</span>
        </footer>
    </div>

    <x-flash />
    @vite(['resources/js/app.js'])
</body>

</html>

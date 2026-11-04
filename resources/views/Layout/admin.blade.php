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
    @vite(['resources/css/app.css', 'resources/css/plugins.min.css'])
    @vite(['resources/css/demo.css', 'resources/css/kaiadmin.min.css', 'resources/css/global.css', 'resources/css/responsive.css'])
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="{{ route('admin.index') }}" class="logo-admin">
                        <img src="{{ Vite::asset('resources/images/job-admin.png') }}" alt="navbar brand"
                            class="navbar-brand" width="70%" height="auto" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item active">
                            <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                                <i class="fas fa-home"></i>
                                <p>Page administrateur</p>
                            </a>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Gestion</h4>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.recruiters') }}">
                                <i class="fas fa-user-check"></i>
                                <p>Liste des recruteurs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.candidates') }}">
                                <i class="fas fa-users"></i>
                                <p>Listes des candidats</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.offers.index') }}">
                                <i class="fas fa-pen-square"></i>
                                <p>Validation offres</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.profils.index') }}">
                                <i class="fas fa-table"></i>
                                <p>Validation Profils</p>
                            </a>
                        </li>
                        @php $adminUnread = auth()->user()->unreadNotifications()->count(); @endphp
                        <li class="nav-item {{ request()->routeIs('notifications.index') ? 'active' : '' }}">
                            <a href="{{ route('notifications.index') }}">
                                <i class="fas fa-bell"></i>
                                <p>Notifications</p>
                                <span class="badge badge-success {{ $adminUnread ? '' : 'd-none' }}" data-notif-count>{{ $adminUnread }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="{{ route('admin.index') }}" class="logo-admin">
                            <img src="{{ Vite::asset('resources/images/job-admin.png') }}" alt="navbar brand"
                                class="navbar-brand" width="70%" height="auto" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <nav class="navbar navbar-header bg-white navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <nav
                            class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                            <a href="{{ route('index') }}" class="accueil">Accueil</a>
                            <form class="input-group" action="{{ route('dashboard.search') }}" method="get" role="search" data-live-search>
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pe-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input type="text" name="q" value="{{ request()->routeIs('dashboard.search') ? request('q') : '' }}" placeholder="Rechercher dans l'administration..." class="form-control" autocomplete="off" />
                            </form>
                        </nav>

                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"
                                    role="button" aria-expanded="false" aria-haspopup="true">
                                    <i class="fa fa-search"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-search animated fadeIn">
                                    <form class="navbar-left navbar-form nav-search" action="{{ route('dashboard.search') }}" method="get" role="search" data-live-search>
                                        <div class="input-group">
                                            <input type="text" name="q" value="{{ request()->routeIs('dashboard.search') ? request('q') : '' }}" placeholder="Rechercher dans l'administration..." class="form-control" autocomplete="off" />
                                        </div>
                                    </form>
                                </ul>
                            </li>
                            <li class="nav-item topbar-icon hidden-caret">
                                <x-notification-bell />
                            </li>

                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">
                                    <div class="avatar-sm">
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
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <div class="user-box">
                                                <div class="avatar-lg">
                                                    <img src="{{ Vite::asset('resources/images/im1.jpg') }}"
                                                        alt="image profile" class="avatar-img rounded" />
                                                </div>
                                                <div class="u-text">
                                                    <h4>
                                                        @auth
                                                            {{ \Illuminate\Support\Facades\Auth::user()->name }}
                                                        @endauth
                                                    </h4>
                                                    <div class="dropdown-divider"></div>
                                                    <p class="text-muted">
                                                        @auth
                                                            {{ \Illuminate\Support\Facades\Auth::user()->email }}
                                                        @endauth
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    </div>
                                </ul>
                            </li>
                            <li class="form-logout">
                                <form method="POST" action="{{ route('logout') }}"
                                    class="d-flex justify-content-center mr-2">
                                    @csrf
                                    <button type="submit" class="icon-logout"><i
                                            class="fa-solid fa-right-from-bracket"></i></button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>
            @yield('content-section')
            <footer class="footer">
                <div class="container-fluid d-flex justify-content-between">
                    <nav class="pull-left">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.index') }}">
                                    Job-admin
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="copyright">
                        Copyright <i class="fa fa-heart heart text-danger"></i> 2025
                    </div>
                </div>
            </footer>
        </div>

        <!-- Custom template | don't include it in your project! -->
        <div class="custom-template">
            <div class="title">Paramètres</div>
            <div class="custom-content">
                <div class="switcher">
                    <div class="switch-block">
                        <h4>Logo Header</h4>
                        <div class="btnSwitch">
                            <button type="button" class="selected changeLogoHeaderColor" data-color="dark"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="blue"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="purple"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="light-blue"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="green"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="orange"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="red"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="white"></button>
                            <br />
                            <button type="button" class="changeLogoHeaderColor" data-color="dark2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="blue2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="purple2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="light-blue2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="green2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="orange2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="red2"></button>
                        </div>
                    </div>
                    <div class="switch-block">
                        <h4>Navbar Header</h4>
                        <div class="btnSwitch">
                            <button type="button" class="changeTopBarColor" data-color="dark"></button>
                            <button type="button" class="changeTopBarColor" data-color="blue"></button>
                            <button type="button" class="changeTopBarColor" data-color="purple"></button>
                            <button type="button" class="changeTopBarColor" data-color="light-blue"></button>
                            <button type="button" class="changeTopBarColor" data-color="green"></button>
                            <button type="button" class="changeTopBarColor" data-color="orange"></button>
                            <button type="button" class="changeTopBarColor" data-color="red"></button>
                            <button type="button" class="selected changeTopBarColor" data-color="white"></button>
                            <br />
                            <button type="button" class="changeTopBarColor" data-color="dark2"></button>
                            <button type="button" class="changeTopBarColor" data-color="blue2"></button>
                            <button type="button" class="changeTopBarColor" data-color="purple2"></button>
                            <button type="button" class="changeTopBarColor" data-color="light-blue2"></button>
                            <button type="button" class="changeTopBarColor" data-color="green2"></button>
                            <button type="button" class="changeTopBarColor" data-color="orange2"></button>
                            <button type="button" class="changeTopBarColor" data-color="red2"></button>
                        </div>
                    </div>
                    <div class="switch-block">
                        <h4>Sidebar</h4>
                        <div class="btnSwitch">
                            <button type="button" class="changeSideBarColor" data-color="white"></button>
                            <button type="button" class="selected changeSideBarColor" data-color="dark"></button>
                            <button type="button" class="changeSideBarColor" data-color="dark2"></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="custom-toggle">
                <i class="fa-solid fa-gear"></i>
            </div>
        </div>
        <!-- End Custom template -->
    </div>
    <x-flash />
    @vite(['resources/js/app.js'])
    @vite(['resources/librairies/setting-demo.js'])
</body>

</html>

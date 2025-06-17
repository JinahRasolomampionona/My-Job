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
    @vite(['resources/css/app.css', 'resources/css/global.css', 'resources/css/responsive.css'])
</head>

<body>
    <main>
        <header>
            <div class="header fixed-top bg-white">
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
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Recruteur
                                        <i class="fas fa-chevron-down toggle-dropdown"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="{{ route('login') }}" data-bs-toggle="modal"
                                                data-bs-target="#loginname">Acces recruteur</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Emploi
                                        <i class="fas fa-chevron-down toggle-dropdown"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="#">Offres d'emploi</a></li>
                                        <li><a class="dropdown-item" href="#">Offres de stage</a></li>
                                        <li><a class="dropdown-item" href="#">Deposer mon CV</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}" data-bs-toggle="modal"
                                        data-bs-target="#loginname">Candidat</a>
                                </li>
                            </ul>
                            <a href="{{ route('login') }}" class="btn-click" class="btn-click align-self-start"
                                data-bs-toggle="modal" data-bs-target="#loginname">Se connecter</a>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        @yield('content-section')
        <footer>
            <div class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <a class="copyright" href="{{ route('index') }}">
                                My job
                            </a>
                            Copyright <i class="fa fa-heart heart text-danger"></i> 2025
                        </div>
                        <div class="social-icons col-lg-6">
                            <a href="#"><i class="fa-brands fa-facebook"></i></a>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-brands fa-google"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </main>
    @vite(['resources/js/app.js'])
    @if (session('showLoginModal'))
        <script>
            console.log(document.getElementById('loginname'))
            document.addEventListener("DOMContentLoaded", function() {
                var loginModal = new bootstrap.Modal(document.getElementById('loginname'));
                loginModal.show();
            });
        </script>
    @endif
    <!-- Bootstrap JS + Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>

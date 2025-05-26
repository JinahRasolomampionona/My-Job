<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/login.css', 'resources/css/app.css', 'resources/js/app.js'])
    <title>My-Job : @yield('title-section')</title>
</head>

<body>
    <!-- <div class="container mt-3">
        <h3>Extra Large Modal Example</h3>
        <p>Click on the button to open the modal.</p>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
            Open modal
        </button>
    </div> -->
    <div class="modal" id="{{$name}}">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <a href="{{ route('index') }}" class="cnx-logo d-flex">
                        <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="Logo">
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 d-flex align-items-center connexion-img">
                                <img src="{{ Vite::asset('resources/images/connexion.jpg') }}" alt="">
                            </div>
                            <div class="col-lg-6 col-md-6 d-flex justify-content-center align-items-center flex-column cnx-content">
                                <h2>Se connecter ou Créer votre compte</h2>
                                @yield("modal-section")
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <a href="#" data-bs-dismiss="modal">Retour >></a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
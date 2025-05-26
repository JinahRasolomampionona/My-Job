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
                            {{-- @if(session('user-register')) <span class="alert alert-success">(session('user-register'))</span>@endif --}}
                            <h2>Se connecter ou Créer votre compte</h2>
                            {{ $slot }}
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
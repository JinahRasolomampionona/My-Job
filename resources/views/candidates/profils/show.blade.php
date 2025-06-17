<div class="modal" id="showProfil">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Details profil</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="container profil-content">
                    <div class="profil-1">
                        <h3 class="text-upper">{{ $user->profil->poste }}</h3>
                        <p><em>{{ $user->profil->descriptionProfil }}</em></p>
                        <p><span>Niveau d'étude: </span>{{ $user->profil->etude }}</p>
                        <p><span>Niveau d'expérience actuel: </span>{{ $user->profil->experience }}</p>
                    </div>
                    <div class="profil-2">
                        <h4 class="text-capitalize">{{ $user->profil->civilite }} {{ $user->profil->nom }}
                            {{ $user->profil->prenom }}
                        </h4>
                        <p><span>Date de naissance: </span>{{ $user->profil->naissance }}</p>
                        <p><span>Adresse: </span>{{ $user->profil->adresse }}</p>
                        <p><span>Contact: </span>{{ $user->profil->contact }}</p>
                        <p><span>Email: </span>
                            @auth
                            {{ \Illuminate\Support\Facades\Auth::user()->email }}
                            @endauth
                        </p>
                    </div>
                    <div class="d-flex">
                        <a href="{{ route('candidates.profils.edit', $user->profil) }}" class="btn btn-primary mr-1"
                            data-bs-toggle="modal" data-bs-target="#editProfil">Editer</a>
                        @include('candidates.profils.edit', $user->profil)
                        <form action="{{ route('candidates.profils.destroy', $user->profil) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success"
                                onclick="return confirm('Voulez-vous vraiment supprimer ce profil ?');">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
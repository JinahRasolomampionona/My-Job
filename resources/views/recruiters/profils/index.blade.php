@extends('Layout.recruiter')
@section('title-section')
Profil candidat
@endsection

@section('content-section')
<div class="container profilshow">
    <div class="page-inner" data-live-results>
        <h3 class="fw-bold mb-3" data-aos="fade-down">
            Profils candidats
            @if ($search)
                <small class="text-muted fs-6">({{ $candidats->count() }} résultat(s) pour « {{ $search }} »)
                    <a href="{{ route('recruiters.profils.index') }}" class="ms-1">Réinitialiser</a></small>
            @endif
        </h3>
        @forelse ($candidats as $candidat)
        @if ($candidat->profil)
        <div class="card" data-aos="fade-up">
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-2 bg-numero">
                            <div class="numero">
                                <span>{{ $candidat->profil->id }}</span>
                            </div>
                        </div>
                        <div class="col-lg-8 pl-2">
                            <h3 class="text-capitalize">
                                <a href="{{ route('recruiters.profils.show', ['user' => $candidat]) }}">
                                    <span class="call">
                                        {{ $candidat->profil->nom }} {{ $candidat->profil->prenom }}
                                    </span>
                                    <span class="mail text-upper text-color">
                                        {{ $candidat->profil->poste }}
                                    </span>
                                </a>
                            </h3>
                            <p>{{ $candidat->profil->descriptionProfil }}</p>
                            <p class="i-color">
                                <span class="call">
                                    <i class="fas fa-phone mr-1"></i>{{ $candidat->profil->contact }}
                                </span>
                                <span class="mail">
                                    <i class="fas fa-envelope mr-1"></i>{{ $candidat->profil->email }}
                                </span>
                            </p>
                        </div>
                        <div class="col-lg-2 d-flex justify-content-center align-items-center icons">
                            <a href="{{ route('recruiters.profils.show', ['user' => $candidat]) }}">
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @empty
        <div class="row"><x-empty-state icon="fa-users" message="Aucun profil validé ne correspond à votre recherche." /></div>
        @endforelse
    </div>
</div>
@endsection
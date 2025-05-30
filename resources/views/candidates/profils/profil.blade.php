@extends('Layout.candidate')
@section('title-section')
Creation profil
@endsection

@section('content-section')
<div class="container profil">
    <div class="page-inner">
        <div class="card">
            <div class="card-body">
                <div class="d-flex profil-title justify-content-between align-items-center">
                    <h2 class="text-upper">Votre profil</h2>
                    <div class="icons">
                        <a href="" class="icon-link" data-bs-toggle="modal" data-bs-target="#createProfil">
                            <i class="fa-solid fa-square-plus"></i>
                        </a>
                        <a href="" class="icon-link" data-bs-toggle="modal" data-bs-target="#editProfil">
                            <i class="fa-solid fa-edit"></i>
                        </a>
                        <a href="" class="icon-link" data-bs-toggle="modal" data-bs-target="#showProfil">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </div>
                </div>
                <div class="container profil-content">
                    @if ($user->profil)
                    <div class="profil-1">
                        <h3 class="text-upper">{{ $user->profil?->poste }}</h3>
                        <p><em>{{ $user->profil?->descriptionProfil }}</em></p>
                        <p><span>Niveau d'étude: </span>{{ $user->profil?->etude }}</p>
                        <p><span>Niveau d'expérience actuel: </span>{{ $user->profil?->experience }}</p>
                    </div>
                    <div class="profil-2">
                        <h4 class="text-capitalize">{{ $user->profil?->civilite }} {{ $user->profil?->nom }}
                            {{ $user->profil?->prenom }}
                        </h4>
                        <p><span>Date de naissance: </span>{{ $user->profil?->naissance }}</p>
                        <p><span>Adresse: </span>{{ $user->profil?->adresse }}</p>
                        <p><span>Contact: </span>{{ $user->profil?->contact }}</p>
                        <p><span>Email: </span>
                            @auth
                            {{ \Illuminate\Support\Facades\Auth::user()->email }}
                            @endauth
                        </p>
                    </div>
                    @include('candidates.profils.edit', $user->profil)
                    @include('candidates.profils.show')
                    @endif


                </div>
            </div>
        </div>
        <!-- The Modal -->
        @include('candidates.profils.create')


        <div class="card">
            <div class="card-body">
                <div class="d-flex profil-title justify-content-between align-items-center">
                    <h2 class="text-upper">Formations</h2>
                    <div class="icons">
                        <a href="" class="icon-link" data-bs-toggle="modal" data-bs-target="#createFormation">
                            <i class="fa-solid fa-square-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="container formation-content">
                    @foreach ($user->formations as $formation)
                    <div class="row">
                        <div class="col-lg-4">
                            <p class=""><strong>{{ $formation->anneeScolaire }}</strong></p>
                            <p class="">{{ $formation->etablissement }}</p>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="diplome">{{ $formation->diplome }}</h5>
                            <p>{{ $formation->descriptionFormation }}</p>
                        </div>
                        <div class="col-lg-2 d-flex justify-content-center align-items-center">
                            <a href="" class="icon-link" data-bs-toggle="modal"
                                data-bs-target="#editFormation-{{ $formation->id }}">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            @include('candidates.formations.edit', $formation)
                            <a href="" class="icon-link" data-bs-toggle="modal"
                                data-bs-target="#showFormation-{{ $formation->id }}">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            @include('candidates.formations.show')
                            <form action="{{ route('candidates.formations.destroy', $formation) }}" method="post">
                                @csrf
                                <button type="submit" class="icon-link"
                                    onclick="return confirm('Voulez-vous vraiment supprimer cette formation ?');"><i
                                        class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                        <hr>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- The Modal -->
        @include('candidates.formations.create')

        <div class="card">
            <div class="card-body">
                <div class="d-flex profil-title justify-content-between align-items-center">
                    <h2 class="text-upper">Expériences professionnelles</h2>
                    <div class="icons">
                        <a href="" class="icon-link" data-bs-toggle="modal" data-bs-target="#createExperience">
                            <i class="fa-solid fa-square-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="container">
                    @foreach ($user->experiences as $experience)
                    <div class="row">
                        <div class="col-lg-4">
                            <p><strong>{{ $experience->moisDebut }} {{ $experience->anneeDebut }} -
                                    {{ $experience->moisFin }} {{ $experience->anneeFin }}</strong></p>
                            <p>{{ $experience->anneeExperience }} d'expérience(s)</p>
                        </div>
                        <div class="col-lg-6">
                            <h5 class="diplome">{{ $experience->societe }} - {{ $experience->posteExperience }}
                            </h5>
                            <p>{{ $experience->descriptionExperience }}</p>
                        </div>
                        <div class="col-lg-2 d-flex justify-content-center align-items-center">
                            <a href="" class="icon-link" data-bs-toggle="modal"
                                data-bs-target="#editExperience-{{ $experience->id }}">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            @include('candidates.experiences.edit', $experience)
                            <a href="" class="icon-link" data-bs-toggle="modal"
                                data-bs-target="#showExperience-{{ $experience->id }}">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            @include('candidates.experiences.show')
                            <form action="{{ route('candidates.experiences.destroy', $experience) }}"
                                method="post">
                                @csrf
                                <button type="submit" class="icon-link"
                                    onclick="return confirm('Voulez-vous vraiment supprimer cette experience ?');"><i
                                        class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                        <hr>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- The Modal -->
        @include('candidates.experiences.create')

    </div>
</div>
@endsection
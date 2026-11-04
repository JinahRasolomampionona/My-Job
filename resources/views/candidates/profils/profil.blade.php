@extends('Layout.candidate')
@section('title-section')
Mon profil
@endsection

@section('content-section')
<div class="container profil">
    <div class="page-inner">
        <div class="card" data-aos="fade-up">
            <div class="card-body">
                <div class="d-flex profil-title justify-content-between align-items-center">
                    <h2 class="text-upper">Votre profil</h2>
                    <div class="icons d-flex align-items-center">
                        @if ($user->profil)
                            @php
                                [$statutLabel, $statutClass] = match ($user->status) {
                                    'validee' => ['Validé', 'bg-success'],
                                    'refusee' => ['Refusé', 'bg-danger'],
                                    default => ['En attente de validation', 'bg-warning text-dark'],
                                };
                            @endphp
                            <span class="badge {{ $statutClass }} me-2">{{ $statutLabel }}</span>
                            <a href="#" class="icon-link" data-bs-toggle="modal" data-bs-target="#editProfil" title="Modifier">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <a href="#" class="icon-link" data-bs-toggle="modal" data-bs-target="#showProfil" title="Aperçu">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        @else
                            <a href="#" class="icon-link" data-bs-toggle="modal" data-bs-target="#createProfil" title="Créer mon profil">
                                <i class="fa-solid fa-square-plus"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="container profil-content">
                    @if ($user->profil)
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
                        <p><span>Email: </span>{{ $user->profil->email }}</p>
                    </div>
                    @include('candidates.profils.edit')
                    @include('candidates.profils.show')
                    @else
                    <div class="empty-state py-4">
                        <i class="fas fa-id-card"></i>
                        <p>Vous n'avez pas encore de profil. Créez-le pour être visible par les recruteurs.</p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProfil">
                            Créer mon profil
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- The Modal -->
        @unless ($user->profil)
            @include('candidates.profils.create')
        @endunless


        <div class="card" data-aos="fade-up" data-aos-delay="100">
            <div class="card-body">
                <div class="d-flex profil-title justify-content-between align-items-center">
                    <h2 class="text-upper">Formations</h2>
                    <div class="icons">
                        <a href="#" class="icon-link" data-bs-toggle="modal" data-bs-target="#createFormation" title="Ajouter">
                            <i class="fa-solid fa-square-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="container formation-content">
                    @forelse ($user->formations as $formation)
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
                            <a href="#" class="icon-link" data-bs-toggle="modal"
                                data-bs-target="#editFormation-{{ $formation->id }}" title="Modifier">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            @include('candidates.formations.edit', ['formation' => $formation])
                            <a href="#" class="icon-link" data-bs-toggle="modal"
                                data-bs-target="#showFormation-{{ $formation->id }}" title="Voir">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            @include('candidates.formations.show', ['formation' => $formation])
                            <form action="{{ route('candidates.formations.destroy', $formation) }}" method="post"
                                data-confirm="Voulez-vous vraiment supprimer cette formation ?">
                                @csrf
                                <button type="submit" class="icon-link" title="Supprimer"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                        <hr>
                    </div>
                    @empty
                    <p class="text-muted py-3 mb-0"><i class="far fa-folder-open me-1"></i>Aucune formation ajoutée.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- The Modal -->
        @include('candidates.formations.create')

        <div class="card" data-aos="fade-up" data-aos-delay="200">
            <div class="card-body">
                <div class="d-flex profil-title justify-content-between align-items-center">
                    <h2 class="text-upper">Expériences professionnelles</h2>
                    <div class="icons">
                        <a href="#" class="icon-link" data-bs-toggle="modal" data-bs-target="#createExperience" title="Ajouter">
                            <i class="fa-solid fa-square-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="container">
                    @forelse ($user->experiences as $experience)
                    <div class="row">
                        <div class="col-lg-4">
                            <p><strong>{{ $experience->moisDebut }} {{ $experience->anneeDebut }} -
                                    {{ $experience->moisFin ?: 'Aujourd\'hui' }} {{ $experience->anneeFin }}</strong></p>
                            @if ($experience->anneeExperience)
                                <p>{{ $experience->anneeExperience }} d'expérience(s)</p>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <h5 class="diplome">{{ $experience->societe }} - {{ $experience->posteExperience }}
                            </h5>
                            <p>{{ $experience->descriptionExperience }}</p>
                        </div>
                        <div class="col-lg-2 d-flex justify-content-center align-items-center">
                            <a href="#" class="icon-link" data-bs-toggle="modal"
                                data-bs-target="#editExperience-{{ $experience->id }}" title="Modifier">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            @include('candidates.experiences.edit', ['experience' => $experience])
                            <a href="#" class="icon-link" data-bs-toggle="modal"
                                data-bs-target="#showExperience-{{ $experience->id }}" title="Voir">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            @include('candidates.experiences.show', ['experience' => $experience])
                            <form action="{{ route('candidates.experiences.destroy', $experience) }}" method="post"
                                data-confirm="Voulez-vous vraiment supprimer cette expérience ?">
                                @csrf
                                <button type="submit" class="icon-link" title="Supprimer"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                        <hr>
                    </div>
                    @empty
                    <p class="text-muted py-3 mb-0"><i class="far fa-folder-open me-1"></i>Aucune expérience ajoutée.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- The Modal -->
        @include('candidates.experiences.create')

    </div>
</div>
@endsection

@extends('Layout.recruiter')
@section('title-section')
Details profil candidat
@endsection

@section('content-section')
<div class="container">
    <div class="page-inner">
        <div class="resume section-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h3 class="resume-title">Profil</h3>
                        <div class="resume-item pb-0">
                            {{-- @dump($user); --}}
                            <h4>{{ $user->profil?->nom }} {{ $user->profil?->prenom }}</h4>
                            <h5 class="text-upper">{{ $user->profil?->poste }}</h5>
                            <p><em>{{ $user->profil?->descriptionProfil }}</em></p>
                            <p><span>Niveau d'étude: </span>{{ $user->profil?->etude }}</p>
                            <p><span>Niveau d'expérience actuel: </span>{{ $user->profil?->experience }}</p>
                            <p><span>Date de naissance: </span>{{ $user->profil?->naissance }}</p>
                            <p><span>Adresse: </span>{{ $user->profil?->adresse }}</p>
                            <p><span>Contact: </span>{{ $user->profil?->contact }}</p>
                        </div>

                        <h3 class="resume-title">Education</h3>
                        @foreach ($user->formations as $formation)
                        <div class="resume-item">
                            <h4>{{ $formation->diplome }}</h4>
                            <h5>{{ $formation->anneeScolaire }}</h5>
                            <p><em>{{ $formation->etablissement }}</em></p>
                            <p>{{ $formation->descriptionFormation }}</p>
                        </div>
                        @endforeach
                    </div>
                    <div class="col-lg-6">
                        <h3 class="resume-title">Expériences professionnelles</h3>
                        @foreach ($user->experiences as $experience)
                        <div class="resume-item">
                            <h4>{{ $experience->posteExperience }}</h4>
                            <h5>{{ $experience->moisDebut }} {{ $experience->anneeDebut }} -
                                {{ $experience->moisFin }} {{ $experience->anneeFin }}
                            </h5>
                            <p><em>{{ $experience->societe }}</em></p>
                            <p>
                            <ul>
                                <li>{{ $experience->descriptionExperience }}</li>
                            </ul>
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
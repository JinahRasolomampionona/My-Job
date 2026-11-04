@extends('Layout.admin')
@section('title-section')
Profil candidat
@endsection

@section('content-section')
<div class="container profilshow">
    <div class="page-inner">
        <h3 class="fw-bold mt-3" data-aos="fade-down">Validation des profils</h3>
        <p class="text-muted">Les profils en attente sont affichés en premier.</p>
        @forelse ($candidats as $candidat)
        @php
            [$statutLabel, $statutClass] = match ($candidat->status) {
                'validee' => ['Validé', 'bg-success'],
                'refusee' => ['Refusé', 'bg-danger'],
                default => ['En attente', 'bg-warning text-dark'],
            };
        @endphp
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
                            <span class="badge {{ $statutClass }} mb-1">{{ $statutLabel }}</span>
                            <h3 class="text-capitalize"><a
                                    href="{{ route('admin.profils.show', ['user' => $candidat]) }}"><span
                                        class="call">
                                        {{ $candidat->profil->nom }} {{ $candidat->profil->prenom }}</span>
                                    <span
                                        class="mail text-upper text-color">{{ $candidat->profil->poste }}</span></a>
                            </h3>
                            <p>{{ $candidat->profil->descriptionProfil }}</p>
                            <p class="i-color"><span class="call"><i
                                        class="fas fa-phone mr-1"></i>{{ $candidat->profil->contact }}</span>
                                <span class="mail"><i class="fas fa-envelope mr-1"></i>
                                    {{ $candidat->profil->email }}
                                </span>
                            </p>
                        </div>
                        <div class="col-lg-2 d-flex justify-content-center align-items-center icons">
                            <a href="{{ route('admin.profils.show', ['user' => $candidat]) }}"><i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="row">
            <x-empty-state icon="fa-id-card" message="Aucun candidat n'a encore créé de profil." />
        </div>
        @endforelse
    </div>
</div>
@endsection

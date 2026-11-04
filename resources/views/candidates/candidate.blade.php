@extends('Layout.candidate')
@section('title-section')
Page candidat
@endsection

@section('content-section')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4" data-aos="fade-down">
            <div>
                <h3 class="fw-bold mb-3">Espace Candidat</h3>
                <h6 class="op-7 mb-2">Bonjour {{ auth()->user()->name }}, voici un résumé de votre activité</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="{{ route('candidates.profils.profil') }}" class="btn btn-primary btn-round">Mon profil</a>
                <a href="{{ route('candidates.offers.index') }}" class="btn btn-success btn-round me-2">Offres</a>
            </div>
        </div>

        {{-- Statut du profil --}}
        @php
            [$alertClass, $alertIcon, $alertText] = match ($statutProfil) {
                null => ['alert-info', 'fa-circle-info', 'Vous n\'avez pas encore de profil. Créez-le pour être visible par les recruteurs et pouvoir postuler.'],
                'validee' => ['alert-success', 'fa-circle-check', 'Votre profil est validé : il est visible par les recruteurs et vous pouvez postuler.'],
                'refusee' => ['alert-danger', 'fa-circle-xmark', 'Votre profil a été refusé. Modifiez-le pour qu\'il soit réexaminé.'],
                default => ['alert-warning', 'fa-hourglass-half', 'Votre profil est en attente de validation par l\'administrateur. Vous serez prévenu par email.'],
            };
        @endphp
        <div class="alert {{ $alertClass }} d-flex align-items-center gap-2" data-aos="fade-up">
            <i class="fas {{ $alertIcon }} fs-4"></i>
            <div class="flex-grow-1">{{ $alertText }}</div>
            @if ($statutProfil !== 'validee')
                <a href="{{ route('candidates.profils.profil') }}" class="btn btn-sm btn-light">Mon profil</a>
            @endif
        </div>

        <div class="row stats">
            <x-stat-card label="Offres disponibles" :value="$totalOffres" icon="fas fa-luggage-cart" color="success"
                :href="route('candidates.offers.index')" />
            <x-stat-card label="Mes candidatures" :value="$totalCandidatures" icon="fas fa-paper-plane" color="primary"
                :href="route('candidates.candidatures.index')" delay="100" />
            <x-stat-card label="Notifications non lues" :value="$totalNotifications" icon="far fa-bell" color="secondary"
                :href="route('notifications.index')" delay="200" />
        </div>
    </div>
</div>
@endsection

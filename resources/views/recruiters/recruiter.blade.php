@extends('Layout.recruiter')
@section('title-section')
Page recruteur
@endsection

@section('content-section')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4" data-aos="fade-down">
            <div>
                <h3 class="fw-bold mb-3">Espace Recruteur</h3>
                <h6 class="op-7 mb-2">Bonjour {{ auth()->user()->name }}, voici un résumé de votre activité</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="{{ route('recruiters.offers.create') }}" class="btn btn-primary btn-round me-2">
                    <i class="fas fa-plus me-1"></i>Publier une offre</a>
                <a href="{{ route('recruiters.profils.index') }}" class="btn btn-success btn-round">Profils</a>
            </div>
        </div>
        <div class="row stats">
            <x-stat-card label="Mes offres" :value="$totalOffres" icon="fas fa-luggage-cart" color="success"
                :href="route('recruiters.offers.index')" />
            <x-stat-card label="Candidatures reçues" :value="$totalCandidatures" icon="fas fa-file-signature" color="info"
                :href="route('recruiters.offers.index')" delay="100" />
            <x-stat-card label="Profils disponibles" :value="$totalProfils" icon="fas fa-users" color="primary"
                :href="route('recruiters.profils.index')" delay="200" />
            <x-stat-card label="Notifications non lues" :value="$totalNotifications" icon="far fa-bell" color="secondary"
                :href="route('notifications.index')" delay="300" />
        </div>
    </div>
</div>
@endsection

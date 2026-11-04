@extends('Layout.admin')
@section('title-section')
dashboard
@endsection

@section('content-section')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4" data-aos="fade-down">
            <div>
                <h3 class="fw-bold mb-3">Dashboard</h3>
                <h6 class="op-7 mb-2">Listes des statistiques</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="{{ route('admin.offers.index') }}" class="btn btn-label-info btn-round me-2">Offres</a>
                <a href="{{ route('admin.profils.index') }}" class="btn btn-primary btn-round">Profils</a>
            </div>
        </div>

        @if ($offresEnAttente || $profilsEnAttente)
            <div class="row mb-2">
                @if ($offresEnAttente)
                    <div class="col-md-6" data-aos="fade-right">
                        <a href="{{ route('admin.offers.index') }}" class="alert alert-warning d-flex align-items-center gap-2 pending-alert">
                            <i class="fas fa-hourglass-half fs-4"></i>
                            <span><strong>{{ $offresEnAttente }}</strong> offre(s) en attente de validation</span>
                            <i class="fas fa-arrow-right ms-auto"></i>
                        </a>
                    </div>
                @endif
                @if ($profilsEnAttente)
                    <div class="col-md-6" data-aos="fade-left">
                        <a href="{{ route('admin.profils.index') }}" class="alert alert-warning d-flex align-items-center gap-2 pending-alert">
                            <i class="fas fa-id-card fs-4"></i>
                            <span><strong>{{ $profilsEnAttente }}</strong> profil(s) en attente de validation</span>
                            <i class="fas fa-arrow-right ms-auto"></i>
                        </a>
                    </div>
                @endif
            </div>
        @endif

        <div class="row">
            <x-stat-card label="Recruteurs" :value="$totalRecruteurs" icon="fas fa-user-check" color="info"
                :href="route('admin.recruiters')" />
            <x-stat-card label="Candidats" :value="$totalCandidats" icon="fas fa-users" color="primary"
                :href="route('admin.candidates')" delay="100" />
            <x-stat-card label="Offres" :value="$totalOffres" icon="fas fa-luggage-cart" color="success"
                :href="route('admin.offers.index')" delay="200" />
            <x-stat-card label="Profils" :value="$totalProfils" icon="far fa-check-circle" color="secondary"
                :href="route('admin.profils.index')" delay="300" />
        </div>
    </div>
</div>
@endsection

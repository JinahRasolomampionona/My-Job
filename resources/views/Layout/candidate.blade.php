@extends('Layout.dashboard')

@section('sidebar-links')
    <a href="{{ route('candidates.candidate') }}" class="page" title="Page Candidat">
        <i class="fas fa-home sidebar-icon"></i><span class="sidebar-label">Page Candidat</span><i class="fas fa-chevron-right i-page"></i>
    </a>

    <a href="{{ route('candidates.profils.profil') }}"
        class="{{ request()->routeIs('candidates.profils.profil') ? 'active' : '' }}" title="Mon profil">
        <i class="fas fa-id-card sidebar-icon"></i><span class="sidebar-label">Mon profil</span>
    </a>

    <a href="{{ route('candidates.offers.index') }}"
        class="{{ request()->routeIs('candidates.offers.*') ? 'active' : '' }}" title="Voir les offres d'emploi">
        <i class="fas fa-briefcase sidebar-icon"></i><span class="sidebar-label">Voir les offres d'emploi</span>
    </a>

    <a href="{{ route('candidates.candidatures.index') }}"
        class="{{ request()->routeIs('candidates.candidatures.index') ? 'active' : '' }}" title="Mes candidatures">
        <i class="fas fa-paper-plane sidebar-icon"></i><span class="sidebar-label">Mes candidatures</span>
    </a>
@endsection

@section('user-menu')
    <li><a class="dropdown-item" href="{{ route('candidates.profils.profil') }}"><i class="fa fa-user me-2"></i>Mon profil</a></li>
    <li><a class="dropdown-item" href="{{ route('candidates.candidatures.index') }}"><i class="fas fa-paper-plane me-2"></i>Mes candidatures</a></li>
@endsection

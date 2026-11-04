@extends('Layout.dashboard')

@section('sidebar-links')
    <a href="{{ route('recruiters.recruiter') }}" class="page" title="Page Recruteur">
        <i class="fas fa-home sidebar-icon"></i><span class="sidebar-label">Page Recruteur</span><i class="fas fa-chevron-right i-page"></i>
    </a>

    <a href="{{ route('recruiters.offers.index') }}"
        class="{{ request()->routeIs('recruiters.offers.*') ? 'active' : '' }}" title="Gestion des offres">
        <i class="fas fa-layer-group sidebar-icon"></i><span class="sidebar-label">Gestion des offres</span>
    </a>

    <a href="{{ route('recruiters.profils.index') }}"
        class="{{ request()->routeIs('recruiters.profils.*') ? 'active' : '' }}" title="Voir les profils">
        <i class="fas fa-users sidebar-icon"></i><span class="sidebar-label">Voir les profils</span>
    </a>
@endsection

@section('user-menu')
    <li><a class="dropdown-item" href="{{ route('recruiters.offers.create') }}"><i class="fas fa-plus me-2"></i>Publier une offre</a></li>
    <li><a class="dropdown-item" href="{{ route('recruiters.offers.index') }}"><i class="fas fa-layer-group me-2"></i>Mes offres</a></li>
@endsection

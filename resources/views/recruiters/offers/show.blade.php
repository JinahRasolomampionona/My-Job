@extends('Layout.recruiter')
@section('title-section')
Details offres
@endsection

@section('content-section')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-lg-9">
                <section id="offre-details" class="offre-details section">
                    <div class="container">
                        <article class="article">
                            <a href="{{ route('recruiters.offers.index') }}"><i class="fa fa-chevron-left fleche"></i></a>
                            <h1 class="title">Details offres</h1>
                            <div class="content">
                                <h2>{{ $offre->titre }}</h2>
                                <h5>{{ $offre->entreprise }} ~ {{ $offre->domaine }}</h5>
                                <p class="local-icon">
                                    <i class="fas fa-map-marker-alt"></i>{{ $offre->localisation }} ~
                                    {{ $offre->contrat }}
                                </p>
                                    <div class="offer-description">{!! $offre->description_html !!}</div>
                            </div><!-- End post content -->
                            @php
                                $statusLabels = ['en attente' => ['En attente de validation', 'bg-warning text-dark'], 'validee' => ['Validée', 'bg-success'], 'refusee' => ['Refusée', 'bg-danger']];
                                [$label, $badge] = $statusLabels[$offre->status] ?? [$offre->status, 'bg-secondary'];
                            @endphp
                            <p>Statut : <span class="badge {{ $badge }}">{{ $label }}</span>
                                @if ($offre->is_urgent) <span class="badge bg-danger"><i class="fas fa-bolt me-1"></i>Urgent</span> @endif
                            </p>
                            <div class="d-flex gap-2">
                                <a href="{{ route('recruiters.offers.edit', $offre) }}" class="btn btn-primary">
                                    <i class="fas fa-pen me-1"></i>Éditer</a>
                                <form action="{{ route('recruiters.offers.destroy', $offre) }}" method="post"
                                    data-confirm="Voulez-vous vraiment supprimer cette offre ?">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash me-1"></i>Supprimer</button>
                                </form>
                            </div>

                            <h4 class="mt-5 mb-3"><i class="fas fa-users text-primary me-2"></i>Candidatures reçues
                                <span class="badge bg-primary">{{ $offre->candidatures->count() }}</span></h4>
                            @forelse ($offre->candidatures as $candidature)
                                <div class="candidature-item" data-aos="fade-up">
                                    <div class="avatar-initials">{{ mb_strtoupper(mb_substr($candidature->user->name, 0, 1)) }}</div>
                                    <div class="flex-grow-1">
                                        <strong>{{ $candidature->user->profil?->prenom }} {{ $candidature->user->profil?->nom ?? $candidature->user->name }}</strong>
                                        <span class="text-muted">· {{ $candidature->user->profil?->poste }}</span>
                                        <small class="d-block text-muted">Le {{ $candidature->created_at->format('d/m/Y à H:i') }}</small>
                                        @if ($candidature->message)
                                            <p class="mb-0 mt-1 fst-italic">« {{ $candidature->message }} »</p>
                                        @endif
                                    </div>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('recruiters.profils.show', $candidature->user) }}" class="btn btn-sm btn-outline-primary">Profil</a>
                                        <a href="mailto:{{ $candidature->user->email }}" class="btn btn-sm btn-outline-success"><i class="fas fa-envelope"></i></a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted"><i class="far fa-folder-open me-1"></i>Aucune candidature pour le moment.</p>
                            @endforelse
                        </article>
                    </div>
                </section>
            </div>

            <div class="col-lg-3">
                <div class="widgets-container">
                    <!-- Carousel -->
                    <div id="demo" class="carousel slide" data-bs-ride="carousel">

                        <!-- Indicators/dots -->
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                            <button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>
                        </div>

                        <!-- The slideshow/carousel -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ Vite::asset('resources/images/why-us.png') }}" alt="">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ Vite::asset('resources/images/img3.jpg') }}" alt="">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ Vite::asset('resources/images/hero-img.png') }}" alt="">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ Vite::asset('resources/images/skills.png') }}" alt="">
                            </div>
                        </div>

                        <!-- Left and right controls/icons -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#demo"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#demo"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                    <!-- Tags Widget -->
                    <div class="tags-widget widget-item">
                        <h3 class="widget-title">Tags</h3>
                        <ul>
                            <li><a href="#">App</a></li>
                            <li><a href="#">IT</a></li>
                            <li><a href="#">Business</a></li>
                            <li><a href="#">Mac</a></li>
                            <li><a href="#">Design</a></li>
                            <li><a href="#">Office</a></li>
                            <li><a href="#">Creative</a></li>
                            <li><a href="#">Studio</a></li>
                            <li><a href="#">Smart</a></li>
                            <li><a href="#">Tips</a></li>
                            <li><a href="#">Marketing</a></li>
                        </ul>
                    </div><!--/Tags Widget -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
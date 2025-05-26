@extends('Layout.layout')
@section('title-section')
    Page d'accueil
@endsection


@section('content-section')
    <section class="home">
        <div class="container-fluid">
            <div class="home-img" data-aos="flip-left" data-aos-duration="2000">
                <h1>Notre job, vous aider à choisir le vôtre parmi <strong>755,827 offres</strong></h1>
            </div>
            <form action="{{ route('search.index') }}" method="get">
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" name="titre" class="form-control" placeholder="Quel job vous fait vibrer ?"
                        aria-label="Username">
                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    <input type="text" class="form-control" name="localite" placeholder="Où voulez-vous briller ?" aria-label="Server">
                    <span class="input-group-text"><button type="submit" class="btn-click">Rechercher</button></span>
                </div>
            </form>
        </div>
    </section>
    <section class="offres mo-2">
        <div class="container section-title my-8" data-aos="fade-up">
            <h2>Résultat de recherche pour <b>{{ $input['titre'] }}</b></h2>
        </div>
        <div class="container">
            <div class="row gy-4">
                @foreach ($offres as $offre)
                    <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <article>
                            <div class="row">
                                <div class="col-9">
                                    <h3 class="post-category text-upper"><a
                                            href="{{ route('offres.show', $offre->id) }}">{{ $offre->titre }}</a></h3>
                                    <h4 class="post-society text-upper"><a
                                            href="{{ route('offres.show', $offre->id) }}">{{ $offre->entreprise }}</a></h4>
                                    <p class="local-icon">
                                        <i class="fas fa-map-marker-alt"></i>{{ $offre->localisation }} ~
                                        <a href="offres-details.html" class="text-upper">{{ $offre->contrat }}</a>
                                    </p>
                                    <p>Domaine: {{ $offre->domaine }}</p>
                                    @php
                                        $date_creation = new DateTime($offre->created_at);
                                    @endphp
                                    <p class="date-create">{{ $date_creation->format('d-m-Y') }}</p>
                                </div>
                                <div class="col-3 d-flex justify-content-center align-items-center icons">
                                    <a href="offres-details.html"><i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

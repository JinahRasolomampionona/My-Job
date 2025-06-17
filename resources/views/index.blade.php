@extends('Layout.layout')
@section('title-section')
Page d'accueil
@endsection


@section('content-section')
<section class="home">
    <div class="container-fluid">
        <div class="home-img" data-aos="flip-left" data-aos-duration="2000">
            <h1 class="" id="title"></h1>
        </div>
        <form action="{{ route('search.index') }}" method="get">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" name="titre" class="form-control" placeholder="Quel job vous fait vibrer ?"
                    aria-label="Username">
                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                <input type="text" class="form-control" name="localite" placeholder="Où voulez-vous briller ?"
                    aria-label="Server">
                <span class="input-group-text"><button type="submit" class="btn-click">Rechercher</button></span>
            </div>
        </form>
    </div>
</section>
<section class="offres">
    <div class="container section-title my-8" data-aos="fade-up">
        <h2>Des entreprises <b>qui recrutent</b></h2>
    </div>
    <div class="container">
        <div class="row gy-4">
            @foreach ($offresView as $offre)
            <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <article>
                    <div class="row">
                        <div class="col-9">
                            <span
                                class="badge @if ($offre->is_urgent) bg-danger @endif">
                                urgent
                            </span>
                            <h3 class="post-category text-upper"><a
                                    href="{{ route('offers.show', $offre->id) }}">{{ $offre->titre }}</a></h3>
                            <h4 class="post-society text-upper"><a
                                    href="{{ route('offers.show', $offre->id) }}">{{ $offre->entreprise }}</a></h4>
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
<section class="job">
    <div class="container section-title" data-aos="fade-up">
        <h2>Trouver un job ? <b>Simple comme Hello</b></h2>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 d-flex justify-content-center align-items-center job-img" data-aos="fade-right"
                data-aos-delay="100">
                <img src="{{ Vite::asset('resources/images/img3.jpg') }}" alt="">
            </div>
            <div class="col-lg-6 d-flex justify-content-center flex-column job-content">
                <div class="icon" data-aos="fade-up">
                    <i class="fas fa-th-list"></i>
                </div>
                <h3 data-aos="fade-right" data-aos-delay="100">Suivez votre candidature</h3>
                <p data-aos="fade-up" data-aos-delay="100">Enfin de la visibilité en direct étape par étape. Postulez et
                    dès que nous avons du nouveau
                    sur l'avancement de votre candidature, vous êtes prévenu !</p>
                <a href="#" class="btn-link align-self-start" data-aos="fade-left" data-aos-delay="100">Voir les
                    offres</a>
            </div>
        </div>
        <div class="row box-2 my-8">
            <div class="col-lg-6 d-flex justify-content-center flex-column job-content order-2 order-lg-1">
                <div class="icon" data-aos="fade-up">
                    <i class="fas fa-layer-group"></i>
                </div>
                <h3 data-aos="fade-right" data-aos-delay="100">Des offres qui ne cachent rien</h3>
                <p data-aos="fade-up" data-aos-delay="100">Salaire, télétravail … N’avancez plus dans l’inconnu pour
                    choisir votre futur job.</p>
                <a href="#" class="btn-link align-self-start" data-aos="fade-right" data-aos-delay="100">Trouver
                    mon job</a>
            </div>
            <div class="col-lg-6 d-flex align-items-center job-img order-1 order-lg-2" data-aos="fade-right"
                data-aos-delay="100">
                <img src="{{ Vite::asset('resources/images/img2.jpg') }}" alt="">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 d-flex align-items-center job-img" data-aos="fade-right" data-aos-delay="100">
                <img src="{{ Vite::asset('resources/images/img1.jpg') }}" alt="">
            </div>
            <div class="col-lg-6 d-flex justify-content-center flex-column job-content">
                <div class="icon" data-aos="fade-up">
                    <i class="fas fa-desktop"></i>
                </div>
                <h3 data-aos="fade-right" data-aos-delay="100">Des entreprises transparentes</h3>
                <p data-aos="fade-up" data-aos-delay="100">Process de recrutement, délai de réponse, avantages… Vous
                    méritez de vraies réponses, pas de
                    perdre du temps.</p>
                <a href="#" class="btn-link align-self-start" data-aos="fade-left" data-aos-delay="100">Voir
                    les entreprises</a>
            </div>
        </div>
    </div>
</section>
<section class="pages">
    <div class="container section-title my-8" data-aos="fade-up">
        <h2>Passer à l'action <b>Rejoignez la plus grande communauté</b></h2>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-5 col-md-6 d-flex flex-column boxes" data-aos="fade-right" data-aos-delay="100">
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <h3>Je suis recruteur</h3>
                <p>Trouvez les meilleurs talents à Madagascar. Accédez à notre base de données de professionnels
                    qualifiés.</p>
                <ul class="list-no-decoration">
                    <li><i class="far fa-check-circle"></i>Accès à plus de 1000 profils tech</li>
                    <li><i class="far fa-check-circle"></i>Système de matching intelligent</li>
                    <li><i class="far fa-check-circle"></i>Contact direct avec les candidats</li>
                </ul>
                <a href="{{ route('login') }}" class="btn-click align-self-start" data-bs-toggle="modal"
                    data-bs-target="#loginname">Commencer à recruter</a>
            </div>
            <div class="col-lg-5 col-md-6 d-flex flex-column boxes" data-aos="fade-up" data-aos-delay="100">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Je suis candidat</h3>
                <p>Créez votre profil professionnel et accédez aux meilleures opportunités de Madagascar.</p>
                <ul class="list-no-decoration">
                    <li><i class="far fa-check-circle"></i>Profil professionnel personnalisé</li>
                    <li><i class="far fa-check-circle"></i>Alertes opportunités en temps réel</li>
                    <li><i class="far fa-check-circle"></i>Mise en relation directe</li>
                </ul>
                <a href="" class="btn-click align-self-start" class="btn-click align-self-start"
                    data-bs-toggle="modal" data-bs-target="#loginname">Créer un profil</a>
            </div>
        </div>
    </div>
    <x-form-modal name="loginname">
        @include('auth.login')
    </x-form-modal>
    <x-form-modal name="registername">
        @include('auth.register')
    </x-form-modal>
    <x-form-modal name="forgotname">
        @include('auth.forgot-password')
    </x-form-modal>
</section>
<section class="outils">
    <div class="container section-title my-8" data-aos="fade-up">
        <h2>Les outils pour <b>Trouver un job</b></h2>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center align-itens-center">
            <div class="col-lg-5 d-flex align-items-center job-img" data-aos="fade-right" data-aos-delay="100">
                <img src="{{ Vite::asset('resources/images/cv-desk.png') }}" alt="">
            </div>
            <div class="col-lg-5 d-flex justify-content-center flex-column job-content">
                <h3 data-aos="fade-up" data-aos-delay="100">Creer votre CV en ligne</h3>
                <p data-aos="fade-up" data-aos-delay="100">Faire un nouveau CV e quelques minutes ? Grace a notre
                    outils de creation de CV en ligne gratuit</p>
                <a href="#" class="btn-link align-self-start" data-aos="fade-left" data-aos-delay="100">Creer
                    un CV</a>
            </div>
        </div>
        <div class="row d-flex justify-content-center align-itens-center my-3">
            <div class="col-lg-5 d-flex justify-content-center flex-column job-content order-2 order-lg-1">
                <h3 data-aos="fade-right" data-aos-delay="100">Creer votre lettre de motivation</h3>
                <p data-aos="fade-up" data-aos-delay="100">Decouvrez tou nos conseils de redaction et exemples de
                    lettre de motivation</p>
                <a href="#" class="btn-link align-self-start" data-aos="fade-right" data-aos-delay="100">Creer
                    une lettre de motivation</a>
            </div>
            <div class="col-lg-5 d-flex align-items-center job-img order-1 order-lg-2" data-aos="fade-up"
                data-aos-delay="100">
                <img src="{{ Vite::asset('resources/images/motif.jpg') }}" alt="">
            </div>
        </div>
    </div>
</section>
@endsection
@extends('Layout.candidate')
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
                            <a href="{{ route('candidates.offers.index') }}"><i class="fa fa-chevron-left fleche"></i></a>
                            <h1 class="title">Details offres</h1>
                            <div class="content">
                                <h2>{{ $offresView->titre }}</h2>
                                <h5>{{ $offresView->entreprise }} ~ {{ $offresView->domaine }}</h5>
                                <p class="local-icon">
                                    <i class="fas fa-map-marker-alt"></i>{{ $offresView->localisation }} ~
                                    {{ $offresView->contrat }}
                                </p>
                                    <div class="offer-description">{!! $offresView->description_html !!}</div>
                            </div><!-- End post content -->
                            <div class="apply-zone" data-apply-zone>
                                @if ($dejaPostule)
                                    <div class="alert alert-success d-inline-flex align-items-center gap-2 mb-0">
                                        <i class="fas fa-circle-check"></i> Vous avez déjà postulé à cette offre.
                                    </div>
                                @else
                                    <form action="{{ route('candidates.offers.apply', $offresView) }}" method="post"
                                        data-ajax="apply" class="apply-form" novalidate>
                                        @csrf
                                        <div class="form-feedback" data-form-message></div>
                                        <label for="apply-message" class="form-label">Message au recruteur (facultatif)</label>
                                        <textarea name="message" id="apply-message" rows="3" class="form-control mb-1" maxlength="1000"
                                            placeholder="Présentez-vous en quelques mots..."></textarea>
                                        <small class="field-error" data-error-for="message"></small>
                                        <div class="d-flex flex-wrap gap-2 mt-2">
                                            <button type="submit" class="btn btn-primary btn-submit">
                                                <span class="btn-label"><i class="fas fa-paper-plane me-1"></i>Postuler</span>
                                            </button>
                                            @if ($offresView->user)
                                                <a href="mailto:{{ $offresView->user->email }}?subject={{ rawurlencode('Candidature : '.$offresView->titre) }}"
                                                    class="btn btn-success"><i class="fas fa-envelope me-1"></i>Contacter le recruteur</a>
                                            @endif
                                        </div>
                                    </form>
                                @endif
                            </div>
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
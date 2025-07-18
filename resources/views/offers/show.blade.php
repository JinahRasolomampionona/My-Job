@extends('Layout.layout')
@section('title-section')
    Details offres
@endsection

@section('content-section')
    <div class="container">
        <div class="page-offre">
            <div class="row">
                <div class="col-lg-9">
                    <section id="offre-details" class="offre-details section">
                        <div class="container">
                            <article class="article">
                                <a href="{{ route('index') }}"><i class="fa fa-chevron-left fleche"></i></a>
                                <h1 class="title">Details offres</h1>
                                <div class="content">
                                    <h2>{{ $offresView->titre }}</h2>
                                    <h5>{{ $offresView->entreprise }} ~ {{ $offresView->domaine }}</h5>
                                    <p class="local-icon">
                                        <i class="fas fa-map-marker-alt"></i>{{ $offresView->localisation }} ~
                                        {{ $offresView->contrat }}
                                    </p>
                                    <p>
                                        {!! $offresView->description !!}
                                    </p>

                                </div><!-- End post content -->
                                <div class="d-flex">
                                    {{-- <a href="{{ route('offers.edit', $offresView->id) }}" class="btn btn-primary mr-1">Editer</a>
                                <form action="{{ route('offers.destroy', $offresView->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Supprimer</button>
                                </form> --}}
                                    <a href="#" class="btn btn-primary mr-1">Postuler</a>
                                    <a href="#" class="btn btn-success mr-1"><i
                                            class="fas fa-phone mr-1"></i>Contacter le recruteur</a>
                                </div>
                            </article>

                        </div>
                    </section>
                </div>
                <div class="col-lg-3 sidebar">
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

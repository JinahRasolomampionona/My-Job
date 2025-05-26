@extends("Layout.layout")
@section("title-section")
Details offres
@endsection

@section("content-section")
<div class="container">
    <div class="page-offre">
        <div class="row">
            <div class="col-lg-9">
                <section id="offre-details" class="offre-details section">
                    <div class="container">
                        <article class="article">
                            <h1 class="title">Details offres</h1>
                            <div class="content">
                                <h2>{{ $offresView->titre }}</h2>
                                <h5>{{ $offresView->entreprise }} ~ {{ $offresView->domaine }}</h5>
                                <p class="local-icon">
                                    <i class="fas fa-map-marker-alt"></i>{{ $offresView->localisation }} ~ {{ $offresView->contrat }}
                                </p>
                                <p>
                                    {!! $offresView->description !!}
                                </p>

                            </div><!-- End post content -->
                            <div class="d-flex">
                                {{-- <a href="{{ route('offres.edit', $offresView->id) }}" class="btn btn-primary mr-1">Editer</a>
                                <form action="{{ route('offres.destroy', $offresView->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Supprimer</button>
                                </form> --}}
                                <a href="#" class="btn btn-primary mr-1">Postuler</a>
                                <a href="#" class="btn btn-success mr-1"><i class="fas fa-phone mr-1"></i>Contacter le recruteur</a>
                            </div>
                        </article>

                    </div>
                </section>
            </div>

            <div class="col-lg-3 sidebar">
                <div class="widgets-container">
                    <!-- Search Widget -->
                    <div class="search-widget widget-item">
                        <h3 class="widget-title">Rechercher</h3>
                        <form action="">
                            <input type="text" name="text" placeholder="Rechercher...">
                            <button type="submit" title="Search"><i class="fa fa-search"></i></button>
                        </form>
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
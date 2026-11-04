@extends('Layout.admin')
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
                            <a href="{{ route('admin.offers.index') }}"><i class="fa fa-chevron-left fleche"></i></a>
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
                            @php
                                $statusLabels = ['en attente' => ['En attente', 'bg-warning text-dark'], 'validee' => ['Validée', 'bg-success'], 'refusee' => ['Refusée', 'bg-danger']];
                                [$label, $badge] = $statusLabels[$offresView->status] ?? [$offresView->status, 'bg-secondary'];
                            @endphp
                            <p class="mb-2">Statut : <span class="badge {{ $badge }}">{{ $label }}</span>
                                @if ($offresView->is_urgent) <span class="badge bg-danger"><i class="fas fa-bolt me-1"></i>Urgent</span> @endif
                                <span class="text-muted ms-2">Publiée par {{ $offresView->user?->name ?? 'compte supprimé' }}</span>
                            </p>
                            <div class="d-flex gap-2">
                                @if ($offresView->status !== 'validee')
                                <form action="{{ route('admin.offre.valider', ['offre' => $offresView]) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-success"><i class="fas fa-check me-1"></i>Valider</button>
                                </form>
                                @endif
                                @if ($offresView->status !== 'refusee')
                                <form action="{{ route('admin.offre.refuser', ['offre' => $offresView]) }}" method="post"
                                    data-confirm="Refuser cette offre ? Le recruteur sera prévenu par email.">
                                    @csrf
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-xmark me-1"></i>Refuser</button>
                                </form>
                                @endif
                            </div>
                        </article>
                    </div>
                </section>
            </div>

            <div class="col-lg-3">
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
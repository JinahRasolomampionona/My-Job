@extends('Layout.admin')
@section('title-section')
Page offres
@endsection

@section('content-section')
<div class="container offres">
    <div class="page-inner">
        <div class="row gy-4 my-2">
            @foreach ($offresView as $offre)
            <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <article>
                    <div class="row">
                        <div class="col-10">
                            <span class="badge status @if ($offre->status === 'en attente') bg-warning @endif">
                                {{ $offre->status }}
                            </span>
                            <span
                                class="badge urgent @if ($offre->is_urgent) bg-danger @endif">
                                urgent
                            </span>
                            <h3 class="post-category text-upper"><a
                                    href="{{ route('admin.offers.show', $offre) }}">{{ $offre->titre }}</a></h3>
                            <h4 class="post-society text-upper"><a
                                    href="{{ route('admin.offers.show', $offre) }}">{{ $offre->entreprise }}</a>
                            </h4>
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
                        <div class="col-2 d-flex justify-content-center align-items-center icons">
                            <a href="{{ route('admin.offers.show', $offre) }}"><i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </article>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
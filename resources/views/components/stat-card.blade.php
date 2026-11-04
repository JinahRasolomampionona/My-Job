{{-- Carte de statistique avec compteur animé (data-count, voir app.js) --}}
@props(['label', 'value', 'icon', 'color' => 'primary', 'href' => '#', 'delay' => 0])

<div class="col-sm-6 col-md-3" data-aos="zoom-in" data-aos-delay="{{ $delay }}">
    <a href="{{ $href }}" class="card card-stats card-round stat-card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-icon">
                    <div class="icon-big text-center icon-{{ $color }} bubble-shadow-small">
                        <i class="{{ $icon }}"></i>
                    </div>
                </div>
                <div class="col col-stats ms-3 ms-sm-0">
                    <div class="numbers">
                        <p class="card-category">{{ $label }}</p>
                        <h4 class="card-title" data-count="{{ (int) $value }}">{{ $value }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

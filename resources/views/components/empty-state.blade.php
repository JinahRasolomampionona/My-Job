{{-- Message affiché quand une liste est vide --}}
@props(['icon' => 'fa-inbox', 'message' => 'Aucun élément pour le moment.'])

<div class="col-12">
    <div class="empty-state" data-aos="fade-up">
        <i class="fas {{ $icon }}"></i>
        <p>{{ $message }}</p>
        {{ $slot }}
    </div>
</div>

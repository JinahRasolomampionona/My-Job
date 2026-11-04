@extends($layout)
@section('title-section')
Notifications
@endsection

@section('content-section')
<div class="container">
    <div class="page-inner">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4" data-aos="fade-down">
            <div>
                <h3 class="fw-bold mb-1"><i class="fas fa-bell text-primary me-2"></i>Mes notifications</h3>
                <p class="text-muted mb-0">Retrouvez ici toutes les alertes de votre compte. Les plus importantes vous sont aussi envoyées par email.</p>
            </div>
            @if (auth()->user()->unreadNotifications()->exists())
                <form method="POST" action="{{ route('notifications.readAll') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-check-double me-1"></i>Tout marquer comme lu
                    </button>
                </form>
            @endif
        </div>

        <div class="notif-page-list">
            @forelse ($notifications as $notification)
                <div class="notif-page-item {{ $notification->read_at ? '' : 'unread' }}" data-aos="fade-up"
                    data-aos-delay="{{ min($loop->index * 50, 300) }}">
                    <span class="notif-icon bg-{{ $notification->data['couleur'] ?? 'primary' }}">
                        <i class="fas {{ $notification->data['icone'] ?? 'fa-bell' }}"></i>
                    </span>
                    <a href="{{ route('notifications.read', $notification->id) }}" class="notif-page-text">
                        <strong>{{ $notification->data['titre'] ?? 'Notification' }}</strong>
                        <span>{{ $notification->data['message'] ?? '' }}</span>
                        <small><i class="far fa-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}</small>
                    </a>
                    <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-light" title="Supprimer"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            @empty
                <div class="row">
                    <x-empty-state icon="fa-bell-slash" message="Vous n'avez aucune notification pour le moment." />
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $notifications->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection

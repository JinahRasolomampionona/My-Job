{{-- Cloche de notifications : rendue côté serveur puis rafraîchie en Ajax toutes les 30 s (resources/js/app.js) --}}
@auth
@php
    $unreadCount = auth()->user()->unreadNotifications()->count();
    $latestNotifications = auth()->user()->notifications()->take(6)->get();
@endphp
<div class="dropdown notif-bell" data-notif-bell data-latest-url="{{ route('notifications.latest') }}"
    data-read-all-url="{{ route('notifications.readAll') }}">
    <button type="button" class="btn notif-bell-btn" data-bs-toggle="dropdown" data-bs-auto-close="outside"
        aria-expanded="false" aria-label="Notifications">
        <i class="fas fa-bell"></i>
        <span class="notif-badge {{ $unreadCount ? '' : 'd-none' }}" data-notif-count>{{ $unreadCount }}</span>
    </button>
    <div class="dropdown-menu dropdown-menu-end notif-panel shadow-lg">
        <div class="notif-panel-header">
            <strong>Notifications</strong>
            <button type="button" class="btn btn-link btn-sm p-0" data-notif-read-all>Tout marquer comme lu</button>
        </div>
        <div class="notif-panel-list" data-notif-list>
            @forelse ($latestNotifications as $notification)
                <a href="{{ route('notifications.read', $notification->id) }}"
                    class="notif-item {{ $notification->read_at ? '' : 'unread' }}">
                    <span class="notif-icon bg-{{ $notification->data['couleur'] ?? 'primary' }}">
                        <i class="fas {{ $notification->data['icone'] ?? 'fa-bell' }}"></i>
                    </span>
                    <span class="notif-text">
                        <strong>{{ $notification->data['titre'] ?? 'Notification' }}</strong>
                        <span>{{ $notification->data['message'] ?? '' }}</span>
                        <small>{{ $notification->created_at->diffForHumans() }}</small>
                    </span>
                </a>
            @empty
                <div class="notif-empty"><i class="far fa-bell-slash"></i> Aucune notification</div>
            @endforelse
        </div>
        <a href="{{ route('notifications.index') }}" class="notif-panel-footer">
            Voir toutes les notifications <i class="fa fa-angle-right"></i>
        </a>
    </div>
</div>
@endauth

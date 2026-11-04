<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Page listant toutes les notifications de l'utilisateur connecté.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        return view('notifications.index', [
            'notifications' => $user->notifications()->paginate(15),
            'layout' => match ($user->homeRoute()) {
                'admin.index' => 'Layout.admin',
                'recruiters.recruiter' => 'Layout.recruiter',
                default => 'Layout.candidate',
            },
        ]);
    }

    /**
     * Dernières notifications au format JSON (appelé en Ajax par la cloche).
     */
    public function latest(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'unread' => $user->unreadNotifications()->count(),
            'items' => $user->notifications()->take(6)->get()->map(fn (DatabaseNotification $n) => [
                'id' => $n->id,
                'titre' => $n->data['titre'] ?? 'Notification',
                'message' => $n->data['message'] ?? '',
                'icone' => $n->data['icone'] ?? 'fa-bell',
                'couleur' => $n->data['couleur'] ?? 'primary',
                'lu' => $n->read_at !== null,
                'date' => $n->created_at->diffForHumans(),
                'url' => route('notifications.read', $n->id),
            ]),
        ]);
    }

    /**
     * Marque une notification comme lue puis redirige vers la page concernée.
     */
    public function read(Request $request, string $id)
    {
        $notification = $request->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        if ($request->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        $url = $notification->data['url'] ?? null;

        // On n'accepte que des chemins internes pour éviter toute redirection externe
        return is_string($url) && str_starts_with($url, '/') && ! str_starts_with($url, '//')
            ? redirect($url)
            : redirect()->route('notifications.index');
    }

    /**
     * Marque toutes les notifications comme lues.
     */
    public function readAll(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'unread' => 0]);
        }

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    /**
     * Supprime une notification.
     */
    public function destroy(Request $request, string $id)
    {
        $request->user()->notifications()->findOrFail($id)->delete();

        if ($request->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        return back();
    }
}

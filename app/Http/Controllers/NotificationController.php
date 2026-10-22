<?php
namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /** GET /notifications — return unread count + latest 10 as JSON */
    public function index()
    {
        $user  = auth()->user();
        $notifs = Notification::where('user_id', $user->id)
            ->latest()
            ->take(15)
            ->get();

        $unread = $notifs->where('is_read', false)->count();

        return response()->json([
            'unread'        => $unread,
            'notifications' => $notifs->map(fn($n) => [
                'id'         => $n->id,
                'type'       => $n->type,
                'title'      => $n->title,
                'message'    => $n->message,
                'icon'       => $n->icon,
                'color'      => $n->color,
                'url'        => $n->url,
                'is_read'    => $n->is_read,
                'time_ago'   => $n->created_at->diffForHumans(),
            ]),
        ]);
    }

    /** POST /notifications/{id}/read */
    public function markRead(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) abort(403);
        $notification->update(['is_read' => true]);
        return response()->json(['ok' => true]);
    }

    /** POST /notifications/read-all */
    public function markAllRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
        return response()->json(['ok' => true]);
    }
}

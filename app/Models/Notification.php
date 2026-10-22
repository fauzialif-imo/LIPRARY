<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id','type','title','message','icon','color','url','is_read'
    ];

    protected $casts = ['is_read' => 'boolean'];

    public function user() { return $this->belongsTo(User::class); }

    // ── Static helpers ─────────────────────────────────────────────

    /** Send a notification to a specific user */
    public static function send(int $userId, string $type, string $title, string $message, array $options = []): self
    {
        return static::create([
            'user_id' => $userId,
            'type'    => $type,
            'title'   => $title,
            'message' => $message,
            'icon'    => $options['icon']  ?? static::iconFor($type),
            'color'   => $options['color'] ?? static::colorFor($type),
            'url'     => $options['url']   ?? null,
            'is_read' => false,
        ]);
    }

    /** Broadcast new-book notification to all active users */
    public static function broadcast(string $type, string $title, string $message, array $options = []): void
    {
        $userIds = User::where('is_active', true)->where('role', 'user')->pluck('id');
        foreach ($userIds as $uid) {
            static::send($uid, $type, $title, $message, $options);
        }
    }

    public static function iconFor(string $type): string
    {
        return match($type) {
            'book_new'         => 'fas fa-book',
            'borrow_approved'  => 'fas fa-check-circle',
            'borrow_rejected'  => 'fas fa-times-circle',
            'return_approved'  => 'fas fa-undo',
            'return_rejected'  => 'fas fa-exclamation-circle',
            'general'          => 'fas fa-bell',
            default            => 'fas fa-bell',
        };
    }

    public static function colorFor(string $type): string
    {
        return match($type) {
            'book_new'         => '#c9a84c',
            'borrow_approved'  => '#1c6b46',
            'borrow_rejected'  => '#c0392b',
            'return_approved'  => '#1a5280',
            'return_rejected'  => '#c0392b',
            default            => '#c9a84c',
        };
    }
}

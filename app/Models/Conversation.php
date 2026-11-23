<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Conversation extends Model
{
    protected $fillable = [
        'user_id',
        'last_message_at',
        'user_unread_count',
        'admin_unread_count',
    ];

    protected function casts(): array
    {
        return [
            'last_message_at' => 'datetime',
            'user_unread_count' => 'integer',
            'admin_unread_count' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('id');
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    /**
     * Resolve the single conversation belonging to the given user,
     * creating it on first use.
     */
    public static function forUser(User $user): self
    {
        return static::firstOrCreate(['user_id' => $user->id]);
    }

    /**
     * Record an incoming message and bump the counters accordingly.
     *
     * @param  string  $senderType  "user" or "admin"
     */
    public function recordMessage(string $senderType): void
    {
        $this->fill([
            'last_message_at' => now(),
            'user_unread_count' => $senderType === 'admin'
                ? ($this->user_unread_count ?? 0) + 1
                : ($this->user_unread_count ?? 0),
            'admin_unread_count' => $senderType === 'user'
                ? ($this->admin_unread_count ?? 0) + 1
                : ($this->admin_unread_count ?? 0),
        ])->save();
    }

    public function markReadForUser(): void
    {
        if ($this->user_unread_count !== 0) {
            $this->fill(['user_unread_count' => 0])->save();
        }
    }

    public function markReadForAdmin(): void
    {
        if ($this->admin_unread_count !== 0) {
            $this->fill(['admin_unread_count' => 0])->save();
        }
    }
}

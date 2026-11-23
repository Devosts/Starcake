<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Message extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Build the payload broadcast to the private channel.
     */
    public function toBroadcastArray(): array
    {
        return [
            'id' => $this->id,
            'conversation_id' => $this->conversation_id,
            'body' => $this->body,
            'sender_type' => $this->sender_type,
            'sender_id' => $this->sender_id,
            'sender_role' => $this->sender_type === Admin::class ? 'admin' : 'user',
            'sender_name' => $this->sender?->name ?? '',
            'created_at' => $this->created_at?->toIso8601String(),
            'created_at_label' => $this->created_at?->format('d M Y, H:i'),
        ];
    }
}

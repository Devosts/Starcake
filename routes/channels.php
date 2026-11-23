<?php

use App\Models\Admin;
use App\Models\Conversation;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/*
 * Private conversation channel: the owning customer, or any active admin.
 * Both the "web" and "admin" guards are allowed to authorize.
 */
Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    if ($user instanceof Admin) {
        return (bool) $user->is_active;
    }

    $conversation = Conversation::find($conversationId);

    return $conversation && (int) $conversation->user_id === (int) $user->id;
}, ['guards' => ['web', 'admin']]);

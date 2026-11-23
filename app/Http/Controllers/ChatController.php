<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Admin;
use App\Models\Conversation;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $user = $request->user();
        $conversation = Conversation::forUser($user);

        $message = $conversation->messages()->create([
            'body' => $data['body'],
            'sender_type' => $user->getMorphClass(),
            'sender_id' => $user->getKey(),
        ]);

        $conversation->recordMessage('user');

        $message->setRelation('sender', $user);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'message' => $message->toBroadcastArray(),
        ]);
    }

    public function read(Request $request)
    {
        $conversation = Conversation::forUser($request->user());

        $conversation->markReadForUser();

        $conversation->messages()
            ->where('sender_type', Admin::class)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['ok' => true]);
    }
}

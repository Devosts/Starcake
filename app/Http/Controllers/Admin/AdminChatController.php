<?php

namespace App\Http\Controllers\Admin;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;

class AdminChatController extends Controller
{
    public function index()
    {
        $conversations = Conversation::with(['user', 'latestMessage'])
            ->withCount('messages')
            ->orderByDesc('last_message_at')
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.chat.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        $conversation->loadMissing('user');

        $messages = $conversation->messages()->with('sender')->get();

        $conversation->markReadForAdmin();

        $conversation->messages()
            ->where('sender_type', User::class)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('admin.chat.show', compact('conversation', 'messages'));
    }

    public function send(Request $request, Conversation $conversation)
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $admin = auth('admin')->user();

        $message = $conversation->messages()->create([
            'body' => $data['body'],
            'sender_type' => $admin->getMorphClass(),
            'sender_id' => $admin->getKey(),
        ]);

        $conversation->recordMessage('admin');

        $message->setRelation('sender', $admin);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'message' => $message->toBroadcastArray(),
        ]);
    }

    public function read(Conversation $conversation)
    {
        $conversation->markReadForAdmin();

        $conversation->messages()
            ->where('sender_type', User::class)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['ok' => true]);
    }
}

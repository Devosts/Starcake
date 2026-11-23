<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Conversation;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __invoke(Request $request)
    {
        $conversation = null;
        $chatMessages = collect();

        if ($request->user()) {
            $conversation = Conversation::forUser($request->user());
            $chatMessages = $conversation->messages()->with('sender')->get();

            $conversation->markReadForUser();
            $conversation->messages()
                ->where('sender_type', Admin::class)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        return view('contact', compact('conversation', 'chatMessages'));
    }
}

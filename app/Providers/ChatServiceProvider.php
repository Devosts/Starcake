<?php

namespace App\Providers;

use App\Models\Conversation;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ChatServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(['layouts.app', 'layouts.admin'], function ($view) {
            $chatUnread = 0;
            $adminChatUnread = 0;

            if ($user = auth()->user()) {
                $chatUnread = (int) optional($user->conversation)->user_unread_count;
            }

            if (auth('admin')->check()) {
                $adminChatUnread = (int) Conversation::sum('admin_unread_count');
            }

            $view->with(compact('chatUnread', 'adminChatUnread'));
        });
    }
}

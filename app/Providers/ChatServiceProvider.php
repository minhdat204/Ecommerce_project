<?php

namespace App\Providers;

use App\Models\ChatSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ChatServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share chat data to chat-widget view
        View::composer('users.partials.chat-widget', function ($view) {
            if (Auth::check()) { // Ensure the user is authenticated
                $chatSession = ChatSession::firstOrCreate([
                    'id_nguoidung' => Auth::id(),
                ]);
                $messages = $chatSession->messages()
                    ->with('user')
                    ->orderBy('thoigian', 'asc')
                    ->get();
                $view->with('messages', $messages);
            } else {
                $view->with('messages', []);
            }
        });
    }
}

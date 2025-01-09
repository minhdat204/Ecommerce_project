<?php

namespace App\Http\Controllers;

use App\Models\ChatSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    private function getOrCreateChatSession(){
        $chatSession = ChatSession::firstOrCreate([
            'id_nguoidung' => Auth::id()
        ]);
        return $chatSession;
    }
}

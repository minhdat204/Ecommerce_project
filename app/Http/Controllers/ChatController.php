<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
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

    public function fireMessage(Request $request){
        $user = Auth::user();
        $chatSession = $this->getOrCreateChatSession();

        // Save to database
        $message = $chatSession->messages()->create([
            'id_nguoigui' => $user->id_nguoidung,
            'noidung' => $request->message,
            'thoigian' => now(),
            'trangthai' => 'sent'
        ]);

        // Dispatch event
        MessageSent::dispatch($message);

        return response()->json([
            'success' => true,
            'message' => [
                'noidung' => $message->noidung,
                'user' => [
                    'loai_nguoidung' => $user->loai_nguoidung,
                    'avatar' => $user->avatar ?? 'https://via.placeholder.com/32',
                    'hoten' => $user->hoten
                ],
                'thoigian' => $message->thoigian->format('g:i A')
            ]
        ]);
    }
}

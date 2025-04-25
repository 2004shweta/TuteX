<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $chats = Chat::where('user_id', $user->id)
                    ->orWhere('tutor_id', $user->id)
                    ->with(['user', 'tutor', 'messages' => function($query) {
                        $query->latest()->take(1);
                    }])
                    ->get();
        
        return view('chat.index', compact('chats'));
    }

    public function show(Chat $chat)
    {
        $this->authorize('view', $chat);
        $messages = $chat->messages()->with('user')->get();
        return view('chat.show', compact('chat', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tutor_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);

        $chat = Chat::firstOrCreate([
            'user_id' => Auth::id(),
            'tutor_id' => $request->tutor_id
        ]);

        $message = $chat->messages()->create([
            'user_id' => Auth::id(),
            'content' => $request->message
        ]);

        // Broadcast the message event
        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }
}
